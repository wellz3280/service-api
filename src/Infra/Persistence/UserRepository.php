<?php

declare(strict_types=1);

namespace Infra\Persistence;

use DateTimeImmutable;
use Domain\Entities\User;
use Domain\Interfaces\UserRepositoryInterface;
use Domain\ValueObjects\Email;
use InvalidArgumentException;
use PDO;

use function sprintf;

final class UserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(User $user): void
    {
        $params  = ':name, :email, :password_hash, :created_at, :deleted_at, :updated_at';
        $columns = 'name, email, password_hash ,created_at, deleted_at, updated_at';
        $sql    = sprintf('INSERT INTO users (%s) Values (%s)', $columns, $params);

        $stmt   = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail()->value(), PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $user->getPassword()->value(), PDO::PARAM_STR);
        $stmt->bindValue(':created_at', $user->getCreatedAtFromTimeStanp(), PDO::PARAM_INT);
        $stmt->bindValue(':deleted_at', null, PDO::PARAM_NULL);
        $stmt->bindValue('updated_at', null, PDO::PARAM_NULL);

        $stmt->execute();
    }

    public function findById(int $id): User
    {
        $sql    = 'SELECT * FROM users WHERE id = :id AND deleted_at IS NULL';
        $stmt   = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch();

        if (!$user) {
            throw new InvalidArgumentException(sprintf('User %s not found.', $id), 404);
        }

        return User::createFromArray([
            'id'         => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'created_at' => $user['created_at'],
            'deleted_at' => $user['deleted_at'],
            'updated_at' => $user['updated_at'],
        ]);
    }

    public function findByEmail(Email $email): User
    {
        $sql    = 'SELECT * FROM users WHERE email = :email AND deleted_at IS NULL';
        $stmt   = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $email->value(), PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        if (!$user) {
            throw new InvalidArgumentException(sprintf('User %s not found.', $email->value()), 404);
        }

        return User::createFromArray([
            'id'         => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'created_at' => $user['created_at'],
            'deleted_at' => $user['deleted_at'],
            'updated_at' => $user['updated_at'],
        ]);
    }

    public function has(int $id): bool
    {
        try {
            if ($this->findById($id) instanceof User) {
                return true;
            }
        } catch (InvalidArgumentException) {
            return false;
        }
    }

    public function hasEmail(Email $email): bool
    {
        try {
            if ($this->findByEmail($email) instanceof User) {
                return true;
            }
        } catch (InvalidArgumentException) {
            return false;
        }
    }

    public function remove(int $id): void
    {
        if (!$this->has($id)) {
            throw new InvalidArgumentException(sprintf('User %s not found.', $id), 404);
        }

        $sql = 'UPDATE users SET deleted_at=:deleted_at WHERE id=:id';
        $stmt   = $this->pdo->prepare($sql);

        $dateTime = (new DateTimeImmutable())->getTimestamp();

        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->bindValue(':deleted_at', (int) $dateTime, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function update(User $user): void
    {
        $id = $user->getId();

        if (!$this->has($id)) {
            throw new InvalidArgumentException(sprintf('User %s not found.', $id), 404);
        }

        $sql = 'UPDATE users SET name=:name WHERE id=:id AND deleted_at IS NULL';
        $stmt   = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', (int) $user->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);

        $stmt->execute();
    }
}
