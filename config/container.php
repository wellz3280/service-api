<?php

declare(strict_types=1);

namespace Config;

use Domain\Interfaces\DbTestsInterface;
use Infra\Factories\DbTestsFactory;
use Infra\Factories\MysqlFactory;
use PDO;

use function DI\factory;

return [
    DbTestsInterface::class => factory(DbTestsFactory::class),
    PDO::class              => factory(MysqlFactory::class),
];