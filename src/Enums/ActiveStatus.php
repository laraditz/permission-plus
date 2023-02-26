<?php

namespace Laraditz\PermissionPlus\Enums;

enum ActiveStatus: int
{
    case Active = 1;
    case Inactive = 0;

    public static function toArray(): array
    {
        return [
            [
                'id' => static::Active,
                'label' => 'Active',
            ],
            [
                'id' => static::Inactive,
                'label' => 'Inactive',

            ],
        ];
    }
}
