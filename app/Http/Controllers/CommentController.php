<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function postComment(Request $request, $article_id)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        // Tạo bình luận mới với trạng thái 'pending'
        $comment = new Comment();
        $comment->article_id = $article_id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->status = 'pending';  // Mặc định trạng thái 'pending'
        $comment->save();

        return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi và đang chờ duyệt.');
    }
    public function getList()
    {
        $comments = Comment::with(['user', 'article'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.comments.list', compact('comments'));
    }
    public function getApprove($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 'approved';
        $comment->save();

        return redirect()->back()->with('success', 'Bình luận đã được duyệt.');
    }
    public function getDelete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Đã xóa bình luận.');
    }
}
