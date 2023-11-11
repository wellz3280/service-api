<?php

declare(strict_types=1);

use Infra\Http\Controller\PingController;
use Infra\Http\Controller\CreateUserController;
use Slim\App;

return function (App $app) {
    $app->get('/ping', PingController::class);
    $app->post('/users', CreateUserController::class);
};