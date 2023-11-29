<?php

declare(strict_types=1);

namespace Tests\Integration\Application\CreateUser;

use Application\CreateUser\CreateUser;
use Application\CreateUser\InputModel;
use Domain\Entities\User;
use Domain\Exceptions\EmailException;
use Domain\ValueObjects\Email;
use Infra\Persistence\UserRepository;
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
                'name'      => 'weliton',
                'email'     => 'w@w.com.br',
                'password'  => '12@Weliton',
            ],
        ]));

        $this->assertTrue($repository->hasEmail(Email::create('w@w.com.br')));
    }

    public function testThrowExceptionWhereEmailIsNotValid(): void
    {
        $pdo        = $this->pdo();
        $repository = new UserRepository($pdo);
        $usecase    = new CreateUser($repository);

        $this->expectException(EmailException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Email is not valid.');

        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'name'      => 'weliton',
                'email'     => 'ww.com.br',
                'password'  => '12@Weliton',
            ],
        ]));
    }

    public function testThrowExceptionWhenEmailExists(): void
    {
        $pdo        = $this->pdo();
        $repository = new UserRepository($pdo);
        $usecase    = new CreateUser($repository);

        $data = [
            User::createFromArray([
                'id'         => 1,
                'name'       => 'jill valentine',
                'email'      => 'valentine.jill@umbrella.com',
                'password'   => '12@Weliton',
            ]),
        ];

        $this->userFactory($data);

        $this->expectException(EmailException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Email already exists');

        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'name'      => 'julia valentine',
                'email'     => 'valentine.jill@umbrella.com',
                'password'  => '12@Weliton',
            ],
        ]));
    }
}
