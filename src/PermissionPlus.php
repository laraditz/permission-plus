<?php

namespace Laraditz\PermissionPlus;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laraditz\PermissionPlus\Enums\ActiveStatus;
use Laraditz\PermissionPlus\Enums\Affirmative;
use Laraditz\PermissionPlus\Models\PermissionPlus as PermissionPlusModel;

class PermissionPlus
{
    public function generatePermissions(bool $overwrite = false)
    {
        $routes = collect(Route::getRoutes())->map(function ($route) use ($overwrite) {

            $action = $route->getAction();
            $middlewares = data_get($action, 'middleware');
            $route_name = $route->getName() ?? data_get($action, 'as');
            $uri = $route->uri;
            $action_name = $route->getActionName();

            if (!$middlewares) return;

            if ($this->isRouteExcluded($uri, $middlewares)) return;

            $allow_all = $this->isAuthRoutes($middlewares) ? Affirmative::No : Affirmative::Yes;
            $allow_guest = $this->isGuestRoutes($middlewares) ? Affirmative::Yes : Affirmative::No;

            $permissionPlus =  $this->getPermissionFromRoute($route);

            if ($permissionPlus) {
                $permissionPlus->update([
                    'name' => $this->getPermissionName($route),
                    'methods' => $route->methods(),
                    'uri' => $uri,
                    'route_name' => $route_name,
                    'allow_all' => $overwrite ? $allow_all : $permissionPlus->allow_all ?? $allow_all,
                    'allow_guest' => $overwrite ? $allow_guest : $permissionPlus->allow_guest ?? $allow_guest,
                    'is_active' => $permissionPlus->is_active ?? ActiveStatus::Active,
                ]);
            } else {
                PermissionPlusModel::create([
                    'action_name' => $action_name,
                    'name' => $this->getPermissionName($route),
                    'methods' => $route->methods(),
                    'uri' => $uri,
                    'route_name' => $route_name,
                    'allow_all' => $allow_all,
                    'allow_guest' => $allow_guest,
                ]);
            }
        });
    }

    private function getPermissionName($route)
    {
        $name = null;

        if ($routeName = $route->getName()) {
            $name = Str::of($routeName)->snake('-')->replace(['.', '-'], ' ')->title();
        } elseif ($route->uri) {

            $name = Str::of($route->uri)->snake('-')->replace(['/', '-'], ' ')->title();
        }

        if ($name && Str::endsWith($name, ['Create', 'Store', 'Show', 'Edit', 'Update', 'Destroy'])) {
            $name = Str::singular(Str::afterLast($name, ' ') . ' ' . Str::beforeLast($name, ' '));
        }

        return $name ?? $route->uri;
    }

    private function isAuthRoutes($middlewares)
    {
        return collect($middlewares)->contains(function ($value) {
            if (Str::startsWith($value, 'auth')) {
                return true;
            }
        });
    }

    private function isGuestRoutes($middlewares)
    {
        return collect($middlewares)->contains(function ($value) {
            if ($value === 'guest') {
                return true;
            }
        });
    }

    private function isRouteExcluded($uri, $middlewares)
    {
        $exclude_routes = config('permission-plus.exclude_routes');

        if (in_array($uri, $exclude_routes)) {
            return true;
        }

        if (config('permission-plus.global_middleware') === false && !in_array('permission.plus', $middlewares)) {
            return true;
        }

        return collect($exclude_routes)->contains(function ($value) use ($uri) {
            if (Str::endsWith($value, '*')) {
                if (Str::startsWith($uri, Str::beforeLast($value, '*'))) {
                    return true;
                }
            }
        });
    }

    public function getPermissionFromRoute(\Illuminate\Routing\Route $route)
    {
        $uri = $route->uri;
        $action_name = $route->getActionName();

        if ($action_name === 'Closure') {
            return PermissionPlusModel::where('action_name', $action_name)->where('uri', $uri)->first();
        } else {
            return PermissionPlusModel::where('action_name', $action_name)->first();
        }

        return null;
    }

    public function checkPermission(PermissionPlusModel $permissionPlus): bool
    {
        if ($permissionPlus->allow_all === 1) return true;

        if ($permissionPlus->allow_guest === 1 && auth()->guest()) return true;

        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasAnyRole($permissionPlus->roles->pluck('name')->toArray())) {
                return true;
            }
        }

        return false;
    }
}
