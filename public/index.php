<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotent = Dotenv::createImmutable(__DIR__.'/../');
$dotent->safeLoad();

/** @var ContainerInterface $container */
$container = require __DIR__.'/../config/bootstrap.php';

/** @var App $app */
$app = $container->get(App::class);

$app->run();
