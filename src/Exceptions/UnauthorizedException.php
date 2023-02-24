<?php

namespace Laraditz\PermissionPlus\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public static function notAlloed(): self
    {
        return new static(403, 'You are not allowed to view this page.', null, []);
    }
}
