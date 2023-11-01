<?php

declare(strict_types=1);

namespace Infra\Persistence;

use Domain\Entities\User;
use Domain\Interfaces\UserRepositoryInterface;
use PDO;

final class UserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(User $user): void
    {
        $values = ':name, :email, :created_at, :deleted_at, :updated_at';
        $sql    = sprintf('INSERT INTO users (name, email, created_at, deleted_at, updated_at) Values (%s)', $values);

        $stmt   = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail()->value(), PDO::PARAM_STR);
        $stmt->bindValue(':created_at', $user->getCreatedAtFromTimeStanp(), PDO::PARAM_INT);
        $stmt->bindValue(':deleted_at', $user->getDeletedAt(), PDO::PARAM_NULL);
        $stmt->bindValue('updated_at', $user->getUpdatedAt(), PDO::PARAM_NULL);

        $stmt->execute();
    }

    public function findById(int $id): User
    {
        
    }

    public function delete(int $id): void
    {
        //
    }

    public function update(User $user): void
    {
        //
    }
}
