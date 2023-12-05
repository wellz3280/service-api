<?php

declare(strict_types=1);

namespace Application\GetUser;

use Application\InputModelInterface;
use Application\ServiceInterface;
use Application\ViewModelInterface;
use DateTimeImmutable;
use PDO;

use function array_map;
use function is_null;

use const DATE_ATOM;

final class GetUser implements ServiceInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(InputModelInterface $input): ViewModelInterface
    {
        $sql = 'SELECT * FROM users WHERE deleted_at IS NULL';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll();

        $output = array_map(function ($row) {
            $createdAt = (new DateTimeImmutable())
                ->setTimestamp($row['created_at'])
                ->format(DATE_ATOM);

            $updatedAt = $row['updated_at'] ?? null;

            if (!is_null($updatedAt)) {
                $updatedAt = (new DateTimeImmutable())
                    ->setTimestamp($updatedAt)
                    ->format(DATE_ATOM);
            }

            return [
                'id'            => $row['id'],
                'name'          => $row['name'],
                'email'         => $row['email'],
                'created_at'    => $createdAt,
                'updated_at'    => $updatedAt,
            ];
        }, (array) $users);

        return ViewModel::createFromArray($output);
    }
}
