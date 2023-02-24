<?php

namespace Laraditz\PermissionPlus\Traits;

trait HasPermissionPlus
{
    public function canAccessPermissionPlus(): bool
    {
        return app()->isLocal() ? true : false;
    }
}
