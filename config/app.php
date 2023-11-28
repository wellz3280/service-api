<?php

declare(strict_types=1);

use function DI\env;

return [
    'name' => env('APP_NAME', 'service-api'),
    'env'   => env('APP_ENVIROMENT', 'local'),
];
