<?php

declare(strict_types=1);

namespace Tests\Support;

use Domain\Interfaces\MysqlDbTestInterface;
use Infra\Factories\ContainerFactory;
use PDO;

use function sprintf;

trait Mysql
{
    public function pdo(): PDO
    {
        $container  = ContainerFactory::create();
        $pdo        = $container->get(MysqlDbTestInterface::class);

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

    public function dropTables(): void
    {
        $pdo    = $this->pdo();
        $tables = [
            'users',
        ];

        for ($i = 0; $i < count($tables); $i++) {
            $pdo->exec(sprintf('DROP TABLE %s', $tables[$i]));
        }
    }

    public function refreshTable(): void
    {
        $this->dropTables();
        $this->createTables($this->pdo());
    }

    protected function setUp(): void
    {
        $this->refreshTable();
        parent::setUp();
    }
}
