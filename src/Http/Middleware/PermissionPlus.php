<?php

namespace Laraditz\PermissionPlus\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laraditz\PermissionPlus\Exceptions\UnauthorizedException;
use Illuminate\Support\Str;

class PermissionPlus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // dd('middleware', $request->route());
        // return $next($request);
        $route  = $request->route();
        $action = $route->getAction();
        $route_name = $route->getName() ?? data_get($action, 'as');

        if (
            Str::startsWith($route_name, 'permission-plus.')
            && auth()->check()
            && auth()->user()->canAccessPermissionPlus()
        ) {
            return $next($request);
        }

        $permission = app('permission-plus')->getPermissionFromRoute($route);

        if (!$permission) { // no permission, let it pass
            return $next($request);
        }

        $isAllowed = app('permission-plus')->checkPermission($permission);

        if ($isAllowed) {
            return $next($request);
        }

        throw UnauthorizedException::notAlloed();

        // $authGuard = Auth::guard($guard);

        // // dd($authGuard);

        // if ($authGuard->guest()) {
        //     throw UnauthorizedException::notLoggedIn();
        // }

        // // dd($authGuard->user());

        // return $next($request);
    }
}
