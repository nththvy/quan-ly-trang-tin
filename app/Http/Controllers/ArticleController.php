<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Status;
use App\Models\Note;
use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Jobs\SendNewArticleEmail;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getList(Request $request)
    {
        $user = Auth::user();
        $query = Article::query();

        // Lọc bài viết theo từ khóa
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('title', 'like', '%' . $keyword . '%');
        }

        // Lấy config status một lần để tránh truy vấn lặp lại
        $statusConfig = [
            'pending_review' => config('status.pending_review'),
            'waiting_editor_edit' => config('status.waiting_editor_edit'),
            'pending_approve' => config('status.pending_approve'),
            'waiting_approver_edit' => config('status.waiting_approver_edit')
        ];

        // Lấy status IDs từ config một lần duy nhất
        $statusIds = Status::whereIn('status', array_values($statusConfig))
            ->pluck('id', 'status')->toArray();

        // Lọc danh sách trạng thái hiển thị trong dropdown và danh sách bài viết theo vai trò
        $statusQuery = Status::query();

        switch ($user->role->name) {
            case 'admin':
                // Admin thấy tất cả trạng thái và bài viết
                break;

            case 'writer':
                // Writer chỉ thấy các status từ bài viết của chính họ
                $query->where('writer_id', $user->id);

                // Lấy các status của bài viết mà writer đã tạo
                $writerStatusIds = Article::where('writer_id', $user->id)
                    ->distinct()
                    ->pluck('status_id');

                $statusQuery->whereIn('id', $writerStatusIds);
                break;

            case 'editor':
                // Editor thấy bài viết cần họ xử lý hoặc đã được họ xử lý
                $editorStatusIds = collect([
                    $statusIds[$statusConfig['pending_review']] ?? null,
                    $statusIds[$statusConfig['waiting_editor_edit']] ?? null
                ])->filter()->values()->all();

                $query->where(function ($q) use ($user, $editorStatusIds) {
                    // Bài viết cần editor xử lý
                    $q->where(function ($subQ) use ($user, $editorStatusIds) {
                        $subQ->whereIn('status_id', $editorStatusIds)
                            ->where(function ($innerQ) use ($user) {
                                $innerQ->whereNull('assigned_editor_id')
                                    ->orWhere('assigned_editor_id', $user->id);
                            });
                    });
                    // Hoặc bài viết đã được editor này xử lý
                    $q->orWhere('editor_id', $user->id);
                });

                // Status cho dropdown - thêm status của bài viết đã được editor này xử lý
                $editedArticleStatusIds = Article::where('editor_id', $user->id)
                    ->distinct()
                    ->pluck('status_id');

                $statusQuery->where(function ($q) use ($editorStatusIds, $editedArticleStatusIds) {
                    $q->whereIn('id', $editorStatusIds)
                        ->orWhereIn('id', $editedArticleStatusIds);
                });
                break;

            case 'approver':
                // Approver thấy bài viết cần họ xử lý hoặc đã được họ xử lý
                $approverStatusIds = collect([
                    $statusIds[$statusConfig['pending_approve']] ?? null,
                    $statusIds[$statusConfig['waiting_approver_edit']] ?? null
                ])->filter()->values()->all();

                $query->where(function ($q) use ($user, $approverStatusIds) {
                    // Bài viết cần approver xử lý
                    $q->whereIn('status_id', $approverStatusIds);
                    // Hoặc bài viết đã được approver này xử lý
                    $q->orWhere('approver_id', $user->id);
                });

                // Status cho dropdown - thêm status của bài viết đã được approver này xử lý
                $approvedArticleStatusIds = Article::where('approver_id', $user->id)
                    ->distinct()
                    ->pluck('status_id');

                $statusQuery->where(function ($q) use ($approverStatusIds, $approvedArticleStatusIds) {
                    $q->whereIn('id', $approverStatusIds)
                        ->orWhereIn('id', $approvedArticleStatusIds);
                });
                break;

            default:
                abort(403, 'Bạn không có quyền truy cập!');
        }

        // Lấy danh sách trạng thái đã lọc
        $statuses = $statusQuery->get();

        // Lọc bài viết theo status nếu được chọn
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // Sử dụng eager loading để tránh N+1 query
        $articles = $query->with(['status', 'writer', 'editor', 'approver'])
            ->latest()
            ->paginate(20)
            ->appends($request->query());

        return view('admin.articles.list', compact('articles', 'statuses'));
    }
    public function getCreate()
    {
        if (Gate::denies('getCreate')) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
        $tags = Tag::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $statuses = Status::pluck('status', 'id');
        return view('admin.articles.create', compact('categories', 'statuses', 'tags'));
    }

    public function postCreate(Request $request)
    {
        //Kiem tra
        if (Gate::denies('postCreate')) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:articles'],
            'category_id' => ['required', 'exists:categories,id'],
            'content' => ['required'],
            'tags' => ['nullable', 'array'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'title.unique' => 'Tiêu đề này đã tồn tại, vui lòng chọn tiêu đề khác.',
        ]);
        // Upload hình ảnh
        $path = '';
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->title, '-') . '.' . $extension;
            $path = Storage::putFileAs('article', $request->file('image'), $filename);
        }

        // Lấy status draft
        $status = Status::where('status', config('status.draft'))->first();

        $orm = new Article();
        $orm->title = $request->title;
        $orm->title_slug = Str::slug($request->title, '-');
        $orm->category_id = $request->category_id;
        $orm->writer_id = Auth::id();
        $orm->summary = $request->summary;
        $orm->content = $request->content;
        $orm->status_id = $status ? $status->id : null;

        if (!empty($path)) $orm->image = $path;
        $orm->save();

        //tạo mới nếu chưa có
        $tagIds = [];
        if ($request->has('tags')) {
            foreach ($request->tags as $tagName) {
                $tagName = trim($tagName);
                $tag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName, '-')]
                );
                $tagIds[] = $tag->id;
            }
            $orm->tags()->sync($tagIds);
        } else {
            $orm->tags()->detach();
        }

        return redirect()->route('admin.articles')->with('success', 'Bài viết đã được lưu dưới dạng nháp.');;
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('ckeditor', $filename, 'local'); // Lưu vào storage/app/ckeditor/

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => asset('storage/app/ckeditor/' . $filename) // Không thể truy cập trực tiếp
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'Upload thất bại!']
        ]);
    }

    public function checkTitle(Request $request)
    {
        $exists = DB::table('articles')->where('title', $request->title)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function getUpdate($id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();

        // Kiểm tra quyền truy cập trang cập nhật bài viết
        if (Gate::denies('getUpdate', $article)) {
            return redirect()->route('admin.articles')->with('error', 'Bạn không có quyền xem bài viết này.');
        }

        $tags = Tag::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $statuses = Status::pluck('status', 'id');

        return view('admin.articles.update', compact('article', 'categories', 'statuses', 'tags'));
    }

    public function postUpdate(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();

        // Kiểm tra quyền thực hiện cập nhật bài viết
        if (Gate::denies('postUpdate', $article)) {
            return redirect()->route('admin.articles')->with('error', 'Bạn không có quyền sửa bài viết này.');
        }
        // Kiểm tra dữ liệu
        $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('articles')->ignore($id)],
            'category_id' => ['required', 'exists:categories,id'],
            'content' => ['required'],
            'tags' => ['nullable', 'array'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'title.unique' => 'Tiêu đề này đã tồn tại, vui lòng chọn tiêu đề khác.',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($article->image) {
                Storage::delete($article->image);
            }

            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->title, '-') . '.' . $extension;
            $path = Storage::putFileAs('article', $request->file('image'), $filename);
            $article->image = $path;
        }

        // Cập nhật dữ liệu
        $article->title = $request->title;
        $article->title_slug = Str::slug($request->title, '-');
        $article->category_id = $request->category_id;
        $article->summary = $request->summary;
        $article->content = $request->content;

        // Nếu writer sửa bài thì set lại trạng thái về "draft"
        if ($user->role->name === 'admin' || $user->role->name === 'writer') {
            // Nếu người viết sửa bài viết, trạng thái sẽ được thay đổi thành 'draft'
            $status = Status::where('status', config('status.draft'))->first();
            $article->status_id = $status->id;
        }
        $article->save();

        $tagIds = [];
        if ($request->has('tags')) {
            foreach ($request->tags as $tagName) {
                $tagName = trim($tagName);
                $tag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName, '-')]
                );
                $tagIds[] = $tag->id;
            }
            $article->tags()->sync($tagIds);
        } else {
            $article->tags()->detach();
        }

        return redirect()->route('admin.articles')->with('success', 'Bài viết đã được cập nhật.');
    }
    public function getNoteForm($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.note', compact('article'));
    }
    public function postSend(Request $request, $articleId)
    {
        $article = Article::findOrFail($articleId);
        // Lấy vai trò của người dùng hiện tại
        $user = Auth::user();

        if (Gate::denies('send', $article)) {
            return redirect()->route('admin.articles')->with('error', 'Hiện tại không thể thực hiện hành động này.');
        }

        if ($user->role->name === 'writer') {
            $status = Status::where('status', config('status.pending_review'))->first();
            if ($request->send_to === 'single' && $request->editor_id) {
                $article->assigned_editor_id = $request->editor_id;
                $article->editor_id = $request->editor_id; // Lưu Editor ngay lập tức
            } else {
                $article->assigned_editor_id = null; // Gửi cho tất cả Editors
            }
        } elseif ($user->role->name === 'editor') {
            $status = Status::where('status', config('status.pending_approve'))->first();
            if ($article->assigned_editor_id === null) {
                $article->editor_id = $user->id; //Lưu editor duyệt bài
            }
        } elseif ($user->role->name === 'approver') {
            $status = Status::where('status', config('status.published'))->first();
            $article->approver_id = $user->id; // Lưu Approver duyệt bài 
        } elseif ($user->role->name === 'admin') {
            $status = Status::where('status', config('status.published'))->first();
            $article->approver_id = $user->id;
        }
        //$article->assigned_editor_id = null; sau khi gửi cho approver thì assigned_editor_id set lại null

        // Tạo ghi chú mới
        if ($status && $article->status_id !== $status->id) {

            $note = new Note();
            $note->user_id = Auth::id();
            $note->article_id = $article->id;
            $note->status_id = $status ? $status->id : null;
            $note->content = $request->content ?? ''; // Nếu không nhập ghi chú thì để trống
            $note->save();
            // Cập nhật trạng thái bài viết
            $article->status_id = $status->id;
            $article->save();

            if ($status->status === config('status.published')) {
                SendNewArticleEmail::dispatch($article);
            }
        }
        return redirect()->route('admin.articles')->with('success', 'Thực hiện thành công.');
    }

    public function requestEdit($id)
    {
        $article = Article::findOrFail($id);

        if (Gate::denies('requestEdit', $article)) {
            return redirect()->back()->with('error', 'Bạn không có quyền yêu cầu chỉnh sửa bài viết này.');
        }
        if ($article->status->status === config('status.pending_review')) {
            $newStatus = config('status.waiting_editor_edit');
        } else {
            $newStatus = config('status.waiting_approver_edit');
        }
        $status = Status::where('status', $newStatus)->first();

        if ($status && $article->status_id !== $status->id) {
            // Tạo ghi chú mới
            $note = new Note();
            $note->user_id = Auth::id();
            $note->article_id = $article->id;
            $note->status_id = $status->id;
            $note->content = $request->content ?? '';
            $note->save();

            // Cập nhật trạng thái bài viết
            $article->status_id = $status->id;
            $article->save();
        }
        return redirect()->route('admin.articles')->with('success', 'Đã gửi yêu cầu chỉnh sửa');
    }
    public function approveEdit($id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();

        // Kiểm tra quyền duyệt bài viết bằng Gate::denies
        if (Gate::denies('approveEdit', $article)) {
            return redirect()->back()->with('error', 'Bạn không có quyền duyệt chỉnh sửa bài viết này.');
        }

        // Xác định trạng thái tiếp theo nếu được duyệt
        $status = Status::where('status', config('status.approved_edit'))->first();

        if ($status && $article->status_id !== $status->id) {
            // Tạo ghi chú mới
            $note = new Note();
            $note->user_id = $user->id;
            $note->article_id = $article->id;
            $note->status_id = $status->id;
            $note->content = $request->content ?? '';
            $note->save();

            // Cập nhật trạng thái bài viết
            $article->status_id = $status->id;
            $article->approver_id = null;
            $article->editor_id = null;
            $article->save();
        }

        return redirect()->route('admin.articles')->with('success', 'Bài viết đã được duyệt chỉnh sửa.');
    }
    public function delete($id)
    {
        $article = Article::findOrFail($id);

        // Kiểm tra quyền xóa bài viết
        if (Gate::denies('delete-article', $article)) {
            return redirect()->route('admin.articles')->with('error', 'Bạn không có quyền xóa bài viết này.');
        }

        // Xóa bài viết
        $article->delete();

        return redirect()->route('admin.articles')->with('success', 'Bài viết đã được xóa.');
    }
    public function postReturn(Request $request, $articleId)
    {
        $article = Article::findOrFail($articleId);
        $user = Auth::user();

        // Kiểm tra quyền trả về bài viết
        if (Gate::denies('return', $article)) {
            return redirect()->route('admin.articles')->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }
        // Cập nhật trạng thái bài viết thành "rejected"
        $status = Status::where('status', config('status.rejected'))->first();
        $article->status_id = $status->id;

        //set assigned_editor = null
        if ($user->role->name === 'editor') {
            $article->assigned_editor_id = null;
        }

        if ($user->role->name === 'approver') {
            $article->editor_id = null;
        }

        if ($status && $article->status_id !== $status->id) {
            // Lưu ghi chú của người duyệt bài
            $note = new Note();
            $note->user_id = Auth::id();
            $note->article_id = $article->id;
            $note->status_id = $status->id;
            $note->content = $request->content ?? 'Bài viết đã bị trả về';
            $note->save();

            // Cập nhật bài viết
            $article->save();
        }

        return redirect()->route('admin.articles')->with('success', 'Bài viết đã được trả về thành công.');
    }
    public function unpublish($articleId)
    {
        $article = Article::findOrFail($articleId);

        // Kiểm tra quyền unpublish của người dùng
        if (Gate::denies('unpublish', $article)) {
            return redirect()->route('admin.articles')->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        $status = Status::where('status', config('status.unpublished'))->first();
        $article->status_id = $status->id;
        $article->save();

        // Tạo ghi chú về việc gỡ xuất bản bài viết
        $note = new Note();
        $note->user_id = Auth::id();
        $note->article_id = $article->id;
        $note->status_id = $status->id;
        $note->content = $request->content ?? '';
        $note->save();

        return redirect()->route('admin.articles')->with('success', 'Bài viết đã được gỡ xuất bản.');
    }
}
