<?php

declare(strict_types=1);

use function DI\env;

return [
    'mysql' => [
        'host'      => env('DATABASE_HOST', 'localhost'),
        'database'  => env('DATABASE', 'servicedb'),
        'username'      => env('USER_NAME', 'root'),
        'password'  => env('PASSWORD', 'root')
    ],
    'dbTest' => [
        'host'      => env('DATABASE_HOST', 'localhost'),
        'database'  => env('DATABASE_TEST', 'servicedbTests'),
        'username'      => env('USER_NAME', 'root'),
        'password'  => env('PASSWORD', 'root')
    ],
];