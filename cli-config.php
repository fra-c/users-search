<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = require __DIR__ . '/app/app.php';

return ConsoleRunner::createHelperSet($app->getContainer()->get(EntityManagerInterface::class));
