<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();

        if ($user) {
            $userRole = $user->roles()->pluck('role_id')->toArray();

            if (in_array($role, $userRole)) {
                return $next($request);
            }
        }
        return redirect('/login');
    }
}
