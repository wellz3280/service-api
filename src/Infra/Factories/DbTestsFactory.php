<?php

declare(strict_types=1);

namespace Infra\Factories;

use DI\Container;
use PDO;

final class DbTestsFactory
{
    public function __invoke(Container $container): PDO
    {
        $service    = $container->get('services')['dbTest'];
        $host       = $service['host'];

        return new PDO(sprintf('mysql:host=%s;dbname=%s', $service['host'], $service['database']),
            $service['username'],
            $service['password']
        );
    }
}
