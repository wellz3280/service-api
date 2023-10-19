<?php

declare(strict_types=1);

use Infra\Controller\PingController;
use Slim\App;

return function (App $app) {
    $app->get('/ping', PingController::class);
};