<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BlockUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Nếu chưa đăng nhập hoặc không có vai trò
        if (!$user || !$user->role) {
            return redirect()->route('frontend.home')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
        }

        // Nếu vai trò là 'user' thì chặn
        if ($user->role->name === 'user') {
            return redirect()->route('frontend.home')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
        }

        return $next($request);
    }
}
