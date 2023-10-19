<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Slim\App;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotent = Dotenv::createImmutable(__DIR__.'/../');
$dotent->safeLoad();

$container = require __DIR__.'/../config/bootstrap.php';
AppFactory::setContainer($container);

$app = AppFactory::create();

$middleware = require __DIR__.'/../config/middleware.php';
$middleware($app);

$routes = require __DIR__.'/../config/routes.php';
$routes($app);

$app->run();
