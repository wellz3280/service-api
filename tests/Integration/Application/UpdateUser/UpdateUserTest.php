<?php

declare(strict_types=1);

namespace Tests\Integration\Application\UpdateUser;

use Application\UpdateUser\InputModel;
use Application\UpdateUser\UpdateUser;
use Domain\Entities\User;
use Infra\Persistence\UserRepository;
use Tests\Support\Mysql;
use Tests\TestCase;

/**
 * @covers Application\UpdateUser\UpdateUser
 */
final class UpdateUserTest extends TestCase
{
    use Mysql;

    public function testUpdateUser(): void
    {
        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $this->userFactory([
            User::createFromArray([
                'id'        => 1,
                'name'      => 'jhonatan wicky',
                'email'     => 'jhonatan.wicky@email.com',
                'password'  => '12@jhonWicky',
            ]),
        ]);

        $usecase = new UpdateUser($repository);
        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'id'    => 1,
                'name'  => 'jhon wicky',
            ],
        ]));
        $user = $repository->findById(1);

        $this->assertSame('jhon wicky', $user->getName());
    }
}
