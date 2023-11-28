<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/container.php');
$containerBuilder->addDefinitions([
    'app'       => require __DIR__ . '/app.php',
    'services'  => require __DIR__ . '/services.php',
]);

return $containerBuilder->build();