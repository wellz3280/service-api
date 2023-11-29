<?php

declare(strict_types=1);

use Infra\Http\Controller\CreateUserController;
use Infra\Http\Controller\GetUserByIdController;
use Infra\Http\Controller\GetUserController;
use Infra\Http\Controller\PingController;
use Infra\Http\Controller\UpdateUserController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app, string $baseUrl) {
    $app->setBasePath($baseUrl);

    $app->group('', function (RouteCollectorProxy $group) {
        $group->get('/ping', PingController::class);
        $group->put('/users/{id}', UpdateUserController::class);
        $group->get('/users/{id}', GetUserByIdController::class);
        $group->post('/users', CreateUserController::class);
        $group->get('/users', GetUserController::class);
    });
};
