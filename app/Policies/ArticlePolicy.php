<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function getCreate(User $user)
    {
        return in_array($user->role->name, ['writer', 'admin']);
    }

    /**
     * Kiểm tra quyền tạo bài viết mới
     */
    public function postCreate(User $user)
    {
        return in_array($user->role->name, ['writer', 'admin']);
    }
    public function getUpdate(User $user, Article $article)
    {
        if ($user->role->name === 'admin') {
            return true;
        }
        if ($article->editor_id === $user->id) {
            return true;
        }

        if ($article->approver_id === $user->id) {
            return true;
        }
        // Trường hợp bài viết đang ở trạng thái 'pending review'
        if ($article->status->status === 'pending review') {
            // Nếu bài viết được gửi cho tất cả editor (assigned_editor_id là null)
            if ($article->assigned_editor_id === null) {
                // Tất cả editor đều có quyền truy cập trang chỉnh sửa
                return $user->role->name === 'editor';
            }

            // Nếu bài viết được chỉ định cho một editor cụ thể
            if ($article->assigned_editor_id !== null) {
                // Nếu người dùng là editor và là người được chỉ định, cho phép truy cập
                return $user->role->name === 'editor' && $article->assigned_editor_id === $user->id;
            }

            // Nếu không phải editor hoặc không được chỉ định, không có quyền truy cập
            return false;
        }

        // Trường hợp bài viết ở trạng thái 'pending approve' hoặc 'chờ approver duyệt chỉnh sửa'
        if (in_array($article->status->status, ['pending approve', 'chờ approver duyệt chỉnh sửa'])) {
            // Chỉ approver mới có quyền truy cập trang chỉnh sửa trong những trạng thái này
            return $user->role->name === 'approver';
        }

        return false;
    }
    public function postUpdate(User $user, Article $article)
    {
        if ($user->role->name === 'admin') {
            return true;
        }
        // Kiểm tra nếu bài viết đang ở trạng thái 'pending review'
        if ($article->status->status === 'pending review') {
            // Nếu bài viết được gửi cho tất cả editor (assigned_editor_id là null)
            if ($article->assigned_editor_id === null) {
                // Tất cả editor đều có quyền sửa bài
                return $user->role->name === 'editor';
            }

            // Nếu bài viết đã được chỉ định cho một editor cụ thể
            if ($article->assigned_editor_id !== null) {
                // Nếu người dùng là editor và là người được chỉ định, cho phép chỉnh sửa
                return $user->role->name === 'editor' && $article->assigned_editor_id === $user->id;
            }
        }
        if ($user->role->name === 'writer' && !in_array($article->status->status, ['draft', 'đã duyệt yêu cầu chỉnh sửa', 'rejected'])) {
            return false;  // Writer không có quyền sửa nếu bài viết không phải là "draft" hoặc "approved"
        }

        // Nếu bài viết không phải trạng thái "pending review", chỉ người viết mới có quyền sửa
        return $article->writer_id === $user->id;
    }
    public function delete(User $user, Article $article)
    {
        if ($user->role->name === 'admin') {
            return true;
        }
        // Kiểm tra nếu bài viết đang ở trạng thái 'draft' và người dùng là tác giả hoặc admin
        if ($article->status->status === 'draft') {
            return $user->id === $article->writer_id || $user->role->name === 'admin';
        }

        // Nếu bài viết không phải ở trạng thái 'draft', không cho phép xóa
        return false;
    }
    public function send(User $user, Article $article)
    {
        $status = $article->status->status; // Lưu trạng thái vào biến trung gian

        // Quyền gửi bài của Admin
        if ($user->role->name === 'admin') {
            return true;
        }

        // Quyền gửi bài của Writer
        if ($user->role->name === 'writer') {
            // Nếu bài viết đang trong trạng thái "pending review" hoặc "pending approve", không cho gửi lại
            if (in_array($status, ['pending review', 'pending approve'])) {
                return false;
            }

            // Writer có thể gửi bài khi bài ở trạng thái "draft" hoặc "approved"
            return in_array($status, ['draft', 'approved']);
        }

        // Quyền gửi bài của Editor
        if ($user->role->name === 'editor') {
            // Editor không thể gửi bài nếu bài đang "pending approve"
            if ($status === 'pending approve') {
                return false;
            }

            // Editor chỉ có thể gửi bài khi bài ở trạng thái "pending review"
            return $status === 'pending review';
        }

        // Quyền gửi bài của Approver
        if ($user->role->name === 'approver') {
            // Approver không thể gửi bài nếu bài đã "published"
            if ($status === 'published') {
                return false;
            }

            // Approver chỉ có thể gửi bài khi bài đang "pending approve"
            return $status === 'pending approve';
        }

        // Trả về false nếu người dùng không thuộc các vai trò trên
        return false;
    }

    public function requestEdit(User $user, Article $article)
    {
        $status = $article->status->status;

        // Kiểm tra trạng thái 'pending review'
        if ($status === 'pending review') {
            return $user->role->name === 'writer';
        }

        // Kiểm tra trạng thái 'pending approve' hoặc 'published'
        if (in_array($status, ['pending approve', 'unpublished'])) {
            return in_array($user->role->name, ['writer']);
        }

        // Nếu bài viết ở trạng thái khác thì không cho yêu cầu chỉnh sửa
        return false;
    }
    public function approveEdit(User $user, Article $article)
    {
        $validStatuses = ['chờ editor duyệt chỉnh sửa', 'chờ approver duyệt chỉnh sửa'];
        $validRoles = ['editor', 'approver'];

        // Kiểm tra nếu trạng thái bài viết hợp lệ và vai trò người dùng hợp lệ
        if (in_array($article->status->status, $validStatuses) && in_array($user->role->name, $validRoles)) {
            return true;
        }

        return false;
    }
    public function return(User $user, Article $article)
    {
        if ($user->role->name === 'admin') {
            return true;
        }
        if ($user->role->name === 'editor' && $article->status->status === 'pending review') {
            return true;
        }

        if ($user->role->name === 'approver' && (in_array($article->status->status, ['published', 'pending approve']))) {
            return true;
        }

        return false;
    }
    public function unpublish(User $user, Article $article)
    {
        return in_array($user->role->name, ['approver', 'admin'])
             && $article->status->status === config('status.published');
    }
}
