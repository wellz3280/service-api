<?php

declare(strict_types=1);

namespace Tests\Support;

use DateTimeImmutable;
use Domain\Entities\User;
use Infra\Factories\ContainerFactory;
use PDO;

use function count;
use function sprintf;

trait Mysql
{
    public function pdo(): PDO
    {
        $container  = ContainerFactory::create();

        return $container->get(PDO::class);
    }

    public function createTables(PDO $pdo): void
    {
        $users = 'CREATE TABLE IF NOT EXISTS users (
            id int(11) AUTO_INCREMENT,
            name varchar(200),
            email varchar(200),
            password_hash varchar(255),
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

    /**
     * @param User[] $users
     */
    public function userFactory(array $users): void
    {
        $pdo = $this->pdo();
        $params  = ':name, :email, :password_hash, :created_at, :deleted_at, :updated_at';
        $columns = 'name, email, password_hash ,created_at, deleted_at, updated_at';
        $sql    = sprintf('INSERT INTO users (%s) Values (%s)', $columns, $params);

        $stmt   = $pdo->prepare($sql);

        foreach ($users as $user) {
            $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail()->value(), PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $user->getPassword()->value(), PDO::PARAM_STR);
            $stmt->bindValue(':created_at', (new DateTimeImmutable())->getTimestamp(), PDO::PARAM_INT);
            $stmt->bindValue(':deleted_at', null, PDO::PARAM_NULL);
            $stmt->bindValue('updated_at', null, PDO::PARAM_NULL);
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
