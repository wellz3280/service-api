<?php

declare(strict_types=1);

namespace Config;

use Domain\Interfaces\UserRepositoryInterface;
use Infra\Factories\AppFactory;
use Infra\Factories\MysqlFactory;
use Infra\Persistence\UserRepository;
use PDO;
use Slim\App;

use function DI\autowire;
use function DI\factory;

return [
    App::class                      => factory(AppFactory::class),
    PDO::class                      => factory(MysqlFactory::class),
    UserRepositoryInterface::class  => autowire(UserRepository::class),
];
