<?php

namespace Laraditz\PermissionPlus;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraditz\PermissionPlus\Skeleton\SkeletonClass
 */
class PermissionPlusFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'permission-plus';
    }
}
