<?php

declare(strict_types=1);

namespace Test\Infra\Persistence;

use Domain\Entities\User;
use Infra\Persistence\UserRepository;
use Tests\Support\Mysql;
use Tests\TestCase;

/**
 * @covers Infra\Persistence\UserRepository
 */
final class UserRepositoryTest extends TestCase
{
    use Mysql;

    public function testSaveUser(): void
    {
        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $pdo = $this->initSetup();
        $repository = new UserRepository($pdo);

        $repository->save($user);

    }
}
