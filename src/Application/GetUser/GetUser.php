<?php

declare(strict_types=1);

namespace Application\GetUser;

use Application\InputModelInterface;
use Application\ServiceInterface;
use Application\ViewModelInterface;
use PDO;

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
        $sql = 'SELECT * FROM users';

        $stmt = $this->pdo->query($sql);

        $users = $stmt->fetchAll();

        $output = array_map(
            fn ($row) => [
                'id'            => $row['id'],
                'name'          => $row['name'],
                'email'         => $row['email'],
                'created_at'    => $row['created_at'],
                'updated_at'    => $row['updated_at'],
            ], (array) $users);

        return ViewModel::createFromArray($output);
    }
}