<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Lấy ID từ route (nếu profile cần truyền ID), hoặc tự kiểm tra theo context
        $requestedUserId = $request->route('id');

        // Nếu chưa đăng nhập hoặc cố truy cập hồ sơ người khác
        if (!$user || ($requestedUserId && $user->id != $requestedUserId)) {
            return redirect()->route('frontend.home')->with('error', 'Bạn không có quyền truy cập hồ sơ này.');
        }

        return $next($request);
    }
}
