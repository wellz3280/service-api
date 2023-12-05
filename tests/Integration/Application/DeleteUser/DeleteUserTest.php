<?php

declare(strict_types=1);

namespace Tests\Integration\Application\DeleteUser;

use Application\DeleteUser\DeleteUser;
use Application\DeleteUser\InputModel;
use Domain\Entities\User;
use Infra\Persistence\UserRepository;
use InvalidArgumentException;
use Tests\Support\Mysql;
use Tests\TestCase;

/**
 * @covers Application\DeleteUser\DeleteUser
 */
final class DeleteUserTest extends TestCase
{
    use Mysql;

    public function testDeleteUser(): void
    {
        $expected = [
            User::createFromArray([
                'id'         => 1,
                'name'       => 'jill valentine',
                'email'      => 'valentine.jill@umbrella.com',
                'password'   => '12@Weliton',
            ]),
        ];
        $this->userFactory($expected);

        $repository = new UserRepository($this->pdo());
        $usecase    = new DeleteUser($repository);
        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'id' => 1,
            ],
        ]));

        $this->assertFalse($repository->has(1));
    }

    public function testThrowExceptionWhenUserNotFound(): void
    {
        $repository = new UserRepository($this->pdo());
        $usecase    = new DeleteUser($repository);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User 123 not found.');
        $this->expectExceptionCode(404);

        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'id' => 123,
            ],
        ]));
    }
}
