<?php

declare(strict_types=1);

namespace Infra\Factories;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

final class ContainerFactory
{
    public static function create(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(__DIR__ . '/../../../config/container.php');
        $containerBuilder->addDefinitions([
            'services'  => require __DIR__ . '/../../../config/services.php',
        ]);

        return $containerBuilder->build();
    }
}
