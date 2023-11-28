<?php

declare(strict_types=1);

namespace Config;

use Domain\Interfaces\UserRepositoryInterface;
use Infra\Factories\MysqlFactory;
use Infra\Persistence\UserRepository;
use PDO;

use function DI\autowire;
use function DI\factory;

return [
    PDO::class                      => factory(MysqlFactory::class),
    UserRepositoryInterface::class  => autowire(UserRepository::class),
];
