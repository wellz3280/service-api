<?php

declare(strict_types=1);

use Infra\Http\Controller\CreateUserController;
use Infra\Http\Controller\GetUserController;
use Infra\Http\Controller\PingController;
use Slim\App;

return function (App $app) {
    $app->get('/ping', PingController::class);
    $app->post('/users', CreateUserController::class);
    $app->get('/users', GetUserController::class);
};
