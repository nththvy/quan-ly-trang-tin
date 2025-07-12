<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        // Đếm số bài viết
        $countPost = Article::count();

        // Đếm số danh mục
        $countCategories = Category::count();

        // Đếm số người quản trị (giả sử có role là 'admin')
        $countAdmin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->count();

        // Đếm số khách hàng (user không có vai trò admin/writer/editor/approver)
        $excludedRoles = ['admin', 'writer', 'editor', 'approver'];
        $countUser = User::whereDoesntHave('roles', function ($query) use ($excludedRoles) {
            $query->whereIn('name', $excludedRoles);
        })->count();

        // Tổng lượt xem (giả sử có cột 'views' trong bảng articles)
        $countView = Article::sum('views');

        // Đếm tổng số bình luận đã được duyệt
        $countComments = Comment::where('status', 'approved')->count();

        return view('admin.home', compact(
            'countPost',
            'countCategories',
            'countAdmin',
            'countUser',
            'countView',
            'countComments'
        ));
    }
}
