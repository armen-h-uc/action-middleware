<?php

declare(strict_types=1);

return [
    'action_middleware_gateway' => env('ACTION_MIDDLEWARE_GATEWAY', 'remote'),
    'redis'                     => [
        'url'      => env('REDIS_URL'),
        'host'     => env('ACTION_MIDDLEWARE_REDIS_HOST', '172.16.12.8'),
        'username' => env('ACTION_MIDDLEWARE_REDIS_USERNAME'),
        'password' => env('ACTION_MIDDLEWARE_REDIS_PASSWORD'),
        'port'     => env('ACTION_MIDDLEWARE_REDIS_PORT', '6379'),
        'database' => env('ACTION_MIDDLEWARE_REDIS_DB', 7),
        'prefix'   => env('ACTION_MIDDLEWARE_REDIS_PREFIX', 'action-middleware:'),
    ],
];