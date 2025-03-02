<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // بررسی آیا کاربر لاگین کرده است یا نه
        if (!Auth::check()) {
            // اگر کاربر لاگین نکرده باشد، به صفحه لاگین هدایت شود
            return redirect()->route('LoginForm')->with('error', 'لطفاً ابتدا وارد شوید.');
        }

        // اگر کاربر لاگین کرده باشد، به درخواست ادامه دهد
        return $next($request);
    }
}
