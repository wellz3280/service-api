<?php

declare(strict_types=1);

namespace Tests\Integration\Application\GetUser;

use Application\GetUser\GetUser;
use Application\GetUser\InputModel;
use DateTimeImmutable;
use Domain\Entities\User;
use Tests\Support\Mysql;
use Tests\TestCase;

/**
 * @covers Application\GetUser\GetUser
 */
final class GetUserTest extends TestCase
{
    use Mysql;

    public function testGetUsers(): void
    {
        $usecase = new GetUser($this->pdo());

        $data = [
            [
                'id'         => 1,
                'name'       => 'jill valentine',
                'email'      => 'valentine.jill@umbrella.com',
            ],
            [
                'id' => 2,
                'name' => 'claire redfield',
                'email' => 'claire.redfield@umbrella.com',
            ],
            [
                'id' => 3,
                'name' => 'leon s. kennedy',
                'email' => 'leon.kennedy@umbrella.com',
            ],
        ];

        $this->userFactory($data);
        /** @var ViewModel $view */
        $view = $usecase->handle(InputModel::createFromArray([]));

        foreach ($view->toArray() as $k => $expected) {
            $this->assertSame($data[$k]['id'], $expected['id']);
            $this->assertSame($data[$k]['name'], $expected['name']);
            $this->assertSame($data[$k]['email'], $expected['email']);
            $this->assertSame((new DateTimeImmutable())->getTimestamp(), $expected['created_at']);
            $this->assertNull($expected['updated_at']);
        }
    }
}
