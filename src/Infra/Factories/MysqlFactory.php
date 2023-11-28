<?php

declare(strict_types=1);

namespace Infra\Factories;

use DI\Container;
use PDO;

use function sprintf;

final class MysqlFactory
{
    public function __invoke(Container $container): PDO
    {
        $service = $container->get('services')['mysql'];

        return new PDO(
            sprintf('mysql:host=%s;dbname=%s', $service['host'], $service['database']),
            $service['username'],
            $service['password']
        );
    }
}
