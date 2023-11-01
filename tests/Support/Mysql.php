<?php

declare(strict_types=1);

namespace Tests\Support;

use Domain\Interfaces\DbTestsInterface;
use Infra\Factories\ContainerFactory;
use PDO;

trait Mysql
{
    public function pdo(): PDO
    {
        $container  = ContainerFactory::create();
        $pdo        = $container->get(DbTestsInterface::class);

        return $pdo;
    }

    public function createTables(PDO $pdo): void
    {
        $users = 'CREATE TABLE IF NOT EXISTS users (
            id int(11) AUTO_INCREMENT,
            name varchar(200),
            email varchar(200),
            created_at int not null,
            deleted_at int,
            updated_at int,
            PRIMARY KEY(id)
        );

        SET character_set_client = utf8;
        SET character_set_connection = utf8;
        SET character_set_results = utf8;
        SET collation_connection = utf8_general_ci;';

        $tables = [
            'users' => $users,
        ];

        foreach ($tables as $table) {
            $stmt   = $pdo->prepare($table);
            $stmt->execute();
        }
    }

    public function initSetup(): PDO
    {
        $pdo = $this->pdo();
        $this->createTables($pdo);

        return $pdo;
    }
}
