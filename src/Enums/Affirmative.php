<?php

namespace Laraditz\PermissionPlus\Enums;

enum Affirmative: int
{
    case Yes = 1;
    case No = 0;

    public static function toArray(): array
    {
        return [
            [
                'id' => static::Yes,
                'label' => 'Yes',
            ],
            [
                'id' => static::No,
                'label' => 'No',

            ],
        ];
    }
}
