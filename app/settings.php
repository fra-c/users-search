<?php

return [
    'displayErrorDetails' => false,

    'database' => [
        'driver' => 'pdo_mysql',
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME'),
        'host' => getenv('DB_HOST'),
        'charset' => 'utf8mb4'
    ],
    'doctrine' => [
        'mappingPaths' => [__DIR__ . '/../src/Infrastructure/Resources/doctrine/config'],
        'proxyDir' => __DIR__ . '/../src/Infrastructure/Resources/doctrine/proxies',
        'isDevMode' => getenv('DEV_MODE')
    ],
    'logger' => [
        'name' => getenv('LOG_NAME'),
        'filename' => empty(getenv('LOG_FILENAME')) ? null : __DIR__ . '/../' . getenv('LOG_FILENAME'),
        'toStderr' => filter_var(getenv('LOG_TO_STDERR'), FILTER_VALIDATE_BOOLEAN)
    ]
];
