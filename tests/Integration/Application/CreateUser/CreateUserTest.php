<?php

declare(strict_types=1);

namespace Tests\Integration\Application\CreateUser;

use Application\CreateUser\CreateUser;
use Application\CreateUser\InputModel;
use Domain\ValueObjects\Email;
use Infra\Persistence\UserRepository;
use InvalidArgumentException;
use Tests\Support\Mysql;
use Tests\TestCase;

/**
 * @covers Application\CreateUser\CreateUser
 */
final class CreateUserTest extends TestCase
{
    use Mysql;

    public function testCreateUser(): void
    {
        $pdo        = $this->pdo();
        $repository = new UserRepository($pdo);
        $usecase    = new CreateUser($repository);

        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'name'  => 'weliton',
                'email' => 'w@w.com.br',
            ],
        ]));

        $this->assertTrue($repository->hasEmail(Email::create('w@w.com.br')));
    }

    public function testThrowExceptionWhereEmailIsNotValid(): void
    {
        $pdo        = $this->pdo();
        $repository = new UserRepository($pdo);
        $usecase    = new CreateUser($repository);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Email is not valid');

        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'name'  => 'weliton',
                'email' => 'ww.com.br',
            ],
        ]));
    }

    public function testThrowExceptionWhenEmailExists(): void
    {
        $pdo        = $this->pdo();
        $repository = new UserRepository($pdo);
        $usecase    = new CreateUser($repository);

        $data = [
            [
                'id'         => 1,
                'name'       => 'jill valentine',
                'email'      => 'valentine.jill@umbrella.com',
            ]
        ];

        $this->userFactory($data);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Email already exists');

        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'name'  => 'julia valentine',
                'email' => 'valentine.jill@umbrella.com',
            ],
        ]));
    }
}
