<?php

namespace Laraditz\PermissionPlus\Enums;

class ActiveStatus
{
    const Active = 1;
    const Inactive = 0;

    public static function toArray(): array
    {
        return [
            [
                'id' => self::Active,
                'label' => 'Active',
            ],
            [
                'id' => self::Inactive,
                'label' => 'Inactive',

            ],
        ];
    }
}
