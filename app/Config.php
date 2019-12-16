<?php

/**
 * Settings
 */

return [

    'settings.httpVersion' => '1.1',
    'settings.responseChunkSize' => 4096,
    'settings.outputBuffering' => 'append',
    'settings.determineRouteBeforeAppMiddleware' => true,
    'settings.displayErrorDetails' => getenv('APP_ENV') === 'dev',

    'db' => [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'database' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
    'twig' => [
        'debug' => true,
        'cache' => getenv('APP_ENV') === 'dev' ? false : __DIR__ . '/../cache/',
    ],
    'redis' => [
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT'),
        'password' => getenv('REDIS_PASSWORD'),
    ]
];