<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'prefix' => 'permission-plus',
    'middleware' => ['web', 'auth'],
    'exclude_routes' => [
        '_ignition/*',
        '_debugbar/*',
    ],
    'global_middleware' => env('PERMISSION_PLUS_GLOBAL_MIDDLEWARE', true),
];
