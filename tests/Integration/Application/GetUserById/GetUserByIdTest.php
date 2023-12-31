<?php

declare(strict_types=1);

namespace Tests\Integration\Application\GetUserById;

use Application\GetUserById\GetUserById;
use Application\GetUserById\InputModel;
use Application\GetUserById\ViewModel;
use Domain\Entities\User;
use Infra\Persistence\UserRepository;
use InvalidArgumentException;
use Tests\Support\Mysql;
use Tests\TestCase;

/**
 * @covers Application\GetUserById\GetUserById
 */
final class GetUserByIdTest extends TestCase
{
    use Mysql;

    public function testGetUserById(): void
    {
        $pdo = $this->pdo();
        $expected = [
            User::createFromArray([
                'id'         => 1,
                'name'       => 'jill valentine',
                'email'      => 'valentine.jill@umbrella.com',
                'password'   => '12@Weliton',
            ]),
        ];

        $this->userFactory($expected);

        $repository = new UserRepository($pdo);
        $usecase    = new GetUserById($repository);

        /** @var ViewModel $view */
        $view = $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'id' => 1,
            ],
        ]));

        $this->assertSame($expected[0]->getId(), $view->id);
    }

    public function testThrowExceptionWhenUserNotFound(): void
    {
        $pdo = $this->pdo();

        $repository = new UserRepository($pdo);
        $usecase    = new GetUserById($repository);

        $this->expectExceptionCode(404);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User 1 not found.');

        $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'id' => 1,
            ],
        ]));
    }
}
