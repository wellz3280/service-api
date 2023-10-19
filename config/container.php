<?php

declare(strict_types=1);

namespace Config;

use Infra\Factories\MysqlFactory;
use PDO;

use function DI\factory;

return [
    PDO::class => factory(MysqlFactory::class),
];