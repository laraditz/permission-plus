<?php

namespace Laraditz\PermissionPlus\Enums;

class Affirmative
{
    const Yes = 1;
    const No = 0;

    public static function toArray(): array
    {
        return [
            [
                'id' => self::Yes,
                'label' => 'Yes',
            ],
            [
                'id' => self::No,
                'label' => 'No',

            ],
        ];
    }
}
