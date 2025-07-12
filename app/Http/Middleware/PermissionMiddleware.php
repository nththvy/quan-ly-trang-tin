<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = Auth::user();
        if (!$user || !($user instanceof \App\Models\User) || !$user->hasPermissionTo($permission)) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request); // <<<< thêm dòng này
    }
}
