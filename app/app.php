<?php

use Dotenv\Dotenv;
use Slim\App;

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv(__DIR__.'/../'))->load();
}

$app = new App(
    array_merge(
        ['settings' => require __DIR__ . '/settings.php'],
        require __DIR__ . '/services.php'
    )
);

require __DIR__ . '/routes.php';

return $app;
