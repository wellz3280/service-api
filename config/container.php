<?php

declare(strict_types=1);

namespace Config;

use Domain\Interfaces\MysqlDbTestInterface;
use Infra\Factories\MysqlDbTestFactory;
use Infra\Factories\MysqlFactory;
use PDO;

use function DI\factory;

return [
    MysqlDbTestInterface::class => factory(MysqlDbTestFactory::class),
    PDO::class              => factory(MysqlFactory::class),
];