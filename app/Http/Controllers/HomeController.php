<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function getHome()
    {
        $tags = Tag::all();
        $categories = Category::all();
        $categories_home = Category::whereNotIn('name', ['Tin dịch vụ', 'Tin dịch vụ doanh nghiệp'])->get();

        $category_1 = Category::where('name', 'Kiến tạo xã hội số')->first();
        $category_2 = Category::where('name', 'Tin báo chí')->first();
        $category_3 = Category::where('name', 'Thông cáo báo chí')->first();
        $category_4 = Category::where('name', 'MWC')->first();
        $category_5 = Category::where('name', 'Công bố thông tin')->first();
        $category_6 = Category::where('name', 'Trách nhiệm xã hội')->first();
        $category_7 = Category::where('name', 'Tin dịch vụ')->first();
        $category_8 = Category::where('name', 'Tin dịch vụ doanh nghiệp')->first();

        $articles = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(6)
            ->get();

        $new_articles_1 = Article::with(['category', 'status', 'writer'])
            ->whereHas('category', function ($query) {
                $query->where('slug', 'tin-bao-chi');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(2)
            ->get();
        $new_articles_2 = Article::with(['category', 'status', 'writer'])
            ->whereHas('category', function ($query) {
                $query->where('slug', 'mwc');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->first();
        $new_articles_3 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'thong-cao-bao-chi');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(2)
            ->get();

        $articles_category_1 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'kien-tao-xa-hoi-so');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(3)
            ->get();

        $articles_category_2 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'tin-bao-chi');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(3)
            ->get();
        $articles_category_3 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'thong-cao-bao-chi');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(4)
            ->get();
        $articles_category_4 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'mwc');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(5)
            ->get();
        $articles_category_5 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'cong-bo-thong-tin');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(5)
            ->get();
        $articles_category_6 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'trach-nhiem-xa-hoi');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(6)
            ->get();
        $articles_category_7 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'tin-dich-vu');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(5)
            ->get();
        $articles_category_8 = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('category', function ($query) {
                $query->where('slug', 'tin-dich-vu-doanh-nghiep');
            })
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->latest()
            ->take(5)
            ->get();
        return view('frontend.home', compact(
            'tags',
            'categories',
            'articles',
            'new_articles_1',
            'new_articles_2',
            'new_articles_3',
            'category_1',
            'category_2',
            'category_3',
            'category_4',
            'category_5',
            'category_6',
            'category_7',
            'category_8',
            'articles_category_1',
            'articles_category_2',
            'articles_category_3',
            'articles_category_4',
            'articles_category_5',
            'articles_category_6',
            'articles_category_7',
            'articles_category_8'
        ));
    }
    public function getArticles_Category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $articles_hot = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->orderByDesc('views')
            ->take(10)
            ->get();
        $articles_latest = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->orderByDesc('updated_at')
            ->take(10)
            ->get();

        $articles = Article::with(['writer'])
            ->withCount('comments')
            ->where('category_id', $category->id)
            ->whereHas('status', fn($q) => $q->where('status', 'published'))
            ->latest()
            ->paginate(10); // mỗi trang 5 bài
        return view('frontend.article_category', compact('category', 'articles', 'articles_hot', 'articles_latest'));
    }
    public function getArticle_Detail($category_slug, $article_slug)
    {
        // Tìm danh mục dựa trên slug trong CSDL (cột 'slug' của bảng categories)
        $category = Category::where('slug', $category_slug)->first();

        if (!$category) {
            abort(404, 'Danh mục không tồn tại.');
        }
        $articles_latest = Article::with(['category', 'status', 'writer']) // load quan hệ nếu có
            ->whereHas('status', function ($query) {
                $query->where('status', config('status.published'));
            })
            ->orderByDesc('updated_at')
            ->take(10)
            ->get();
        // Tìm bài viết thuộc danh mục có title_slug tương ứng
        $article = Article::with(['category', 'writer', 'tags', 'status', 'comments.user'])
            ->whereHas('category', function ($query) use ($category_slug) {
                $query->where('slug', $category_slug);
            })
            ->where('title_slug', $article_slug) // Dùng đúng cột title_slug trong bảng articles
            ->whereHas('status', function ($query) {
                $query->where('status', 'published');
            })
            ->first();

        if (!$article) {
            abort(404, 'Bài viết không tồn tại hoặc chưa được xuất bản.');
        }
        // Lọc bình luận: đã duyệt hoặc của chính user
        $visibleComments = $article->comments->filter(function ($comment) {
            return $comment->status === 'approved' || (Auth::check() && $comment->user_id === Auth::id());
        });
        $countComments = $article->comments->where('status', 'approved')->count();
        // Lấy danh sách tất cả danh mục nếu cần cho sidebar/menu
        $categories = Category::all();
        // Tăng lượt xem nếu chưa có trong session
        $articleKey = 'article_viewed_' . $article->id;
        if (!session()->has($articleKey)) {
            $article->increment('views');
            session()->put($articleKey, true);
        }

        $relatedArticles = Article::whereHas('tags', function ($query) use ($article) {
            $query->whereIn('tags.id', $article->tags->pluck('id'));
        })
            ->where('id', '!=', $article->id)
            ->whereHas('status', function ($query) {
                $query->where('status', 'published');
            })
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('frontend.article', compact('article', 'category', 'categories', 'relatedArticles', 'visibleComments', 'countComments','articles_latest'));
    }
    public function search(Request $request)
    {
        $title = 'Kết quả tìm kiếm';

        // Xác thực từ khóa tìm kiếm
        $request->validate([
            'keyword' => ['required', 'string', 'min:1'],
        ]);

        // Lấy từ khóa từ request
        $keyword = $request->keyword;

        // Lấy danh sách bài viết theo từ khóa và danh mục (nếu có)
        $articles = Article::with(['writer', 'category'])
            ->withCount('comments')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            })
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id)) // Sử dụng request('category_id')
            ->whereHas('status', fn($q) => $q->where('status', config('status.published')))
            ->latest()
            ->paginate(5) // Phân trang
            ->withQueryString(); // Giữ lại các query string

        // Lấy tất cả các danh mục
        $categories = Category::all();

        return view('frontend.search', compact('articles', 'title', 'categories', 'keyword'));
    }
    public function hotArticles(Request $request)
    {
        $title = 'Bài viết xem nhiều nhất';

        $articles = Article::with(['writer', 'category'])
            ->withCount('comments')
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id)) // Sử dụng request('category_id')
            ->whereHas('status', fn($q) => $q->where('status', config('status.published')))
            ->orderByDesc('views')
            ->paginate(20)
            ->withQueryString(); // Giữ query string khi phân trang

        // Lấy tất cả các danh mục
        $categories = Category::all();

        return view('frontend.hot_articles', compact('articles', 'title', 'categories'));
    }
    public function latestArticles(Request $request)
    {
        $title = 'Bài viết mới nhất';

        $articles = Article::with(['writer', 'category'])
            ->withCount('comments')
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id)) // Sử dụng request('category_id')
            ->whereHas('status', fn($q) => $q->where('status', config('status.published')))
            ->orderByDesc('updated_at') // Sắp xếp theo thời gian tạo, bài viết mới nhất sẽ lên đầu
            ->paginate(20)
            ->withQueryString(); // Giữ query string khi phân trang

        // Lấy tất cả các danh mục
        $categories = Category::all();

        return view('frontend.latest_articles', compact('articles', 'title', 'categories'));
    }
    // User chỉ được xóa comment của chính họ
    public function userDelete($id)
    {
        $comment = Comment::findOrFail($id);

        // Kiểm tra xem người dùng hiện tại có phải là chủ sở hữu của bình luận không
        if (Auth::id() === $comment->user_id) {
            $comment->delete();
            return back()->with('success', 'Bình luận đã được xóa.');
        }

        return back()->with('error', 'Bạn không có quyền xóa bình luận này.');
    }
    public function getAllCategories()
    {
        $category_all = Category::withCount(['articles' => function ($query) {
            $query->whereHas('status', function ($q) {
                $q->where('status', 'published');
            });
        }])
            ->latest()
            ->paginate(12); // phân trang

        return view('frontend.all_categories', compact('category_all'));
    }
    public function getArticles_Tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $articles_hot = Article::with(['category', 'status', 'writer'])
            ->whereHas('status', fn($q) => $q->where('status', config('status.published')))
            ->orderByDesc('views')
            ->take(10)
            ->get();

        $articles_latest = Article::with(['category', 'status', 'writer'])
            ->whereHas('status', fn($q) => $q->where('status', config('status.published')))
            ->orderByDesc('updated_at')
            ->take(10)
            ->get();

        $articles = Article::with(['writer', 'category'])
            ->withCount('comments')
            ->whereHas('tags', fn($q) => $q->where('slug', $slug))
            ->whereHas('status', fn($q) => $q->where('status', config('status.published')))
            ->latest()
            ->paginate(10);

        return view('frontend.article_tag', compact('tag', 'articles', 'articles_hot', 'articles_latest'));
    }
}
