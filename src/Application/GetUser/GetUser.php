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

        return ViewModel::createFromArray($users);
    }
}