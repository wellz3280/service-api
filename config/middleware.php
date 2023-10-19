<?php

declare(strict_types=1);

use Slim\App;

require __DIR__ . '/../vendor/autoload.php';

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware(true, true, true);
};