<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Hiển thị form ghi chú khi gửi duyệt bài viết
    public function getNote($articleId)
    {
        $article = Article::findOrFail($articleId);
        $notes = $article->notes()->with('user', 'status')->latest()->get();

        // Lấy danh sách những người có vai trò editor
        $editors = User::whereHas('role', function ($query) {
            $query->where('name', 'editor');
        })->get();
        return view('admin.articles.note', compact('article', 'editors', 'notes'));
    }
    public function getNoteforRequest($articleId)
    {
        $article = Article::findOrFail($articleId);
        if (!in_array($article->status->status, ['draft', 'đã duyệt yêu cầu chỉnh sửa'])) {
            return redirect()->route('admin.articles')->with('error', 'Bài viết này đã được gửi duyệt.');
        }
        // Lấy danh sách những người có vai trò reviewer
        $approvers = User::whereHas('role', function ($query) {
            $query->where('name', 'approver');
        })->get();
        return view('admin.articles.note', compact('article', 'approvers'));
    }
}
