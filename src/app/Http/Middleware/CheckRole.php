<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle($request, Closure $next, $role)
    // {
    //     // ユーザーが指定されたショップに関連付けられた指定されたロールを持っているかを確認する
    //     $user = $request->user();
    //     if ($user && $user->roles()->wherePivot('role_id', $role)->exists()) {
    //         // ロールが存在する場合は、リクエストを続行します
    //         return $next($request);
    //     }

    //     // 権限がない場合に 403 エラーを返す
    //     return redirect('/login');
    // }

    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();

        if ($user) {
            $userRole = $user->roles()->pluck('role_id')->toArray();
            \Log::debug('User Roles: ' . implode(',', $userRole));

            if (in_array($role, $userRole)) {
                return $next($request);
            }
        }

        \Log::debug('User does not have the required role');
        return redirect('/login');
    }
}
