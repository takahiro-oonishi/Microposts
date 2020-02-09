<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
     //handle() は全てのミドルウェアが持っているもので、ミドルウェアが設定されたルーティングにアクセスされたときに毎回呼ばれるメソッドです。
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {//if (Auth::guard($guard)->check()) でログインしているかどうかを判断しています。
            return redirect('/');
        }

        return $next($request);
    }
}
