<?php

declare(strict_types=1);

namespace Tests\Integration\Application\GetUserById;

use Application\GetUserById\GetUserById;
use Application\GetUserById\InputModel;
use Infra\Persistence\UserRepository;
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
            [
                'id'         => 1,
                'name'       => 'jill valentine',
                'email'      => 'valentine.jill@umbrella.com',
            ],
        ];

        $this->userFactory($expected);

        $repository = new UserRepository($pdo);
        $usecase    = new GetUserById($repository);
        $view = $usecase->handle(InputModel::createFromArray([
            'payload' => [
                'id' => 1,
            ],
        ]));

        $this->assertSame($expected[0]['id'], $view->id);
    }
}