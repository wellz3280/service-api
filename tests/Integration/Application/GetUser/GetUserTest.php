<?php

declare(strict_types=1);

namespace Tests\Integration\Application\GetUser;

use Application\GetUser\GetUser;
use Application\GetUser\InputModel;
use Application\GetUser\ViewModel;
use DateTimeImmutable;
use Domain\Entities\User;
use Tests\Support\Mysql;
use Tests\TestCase;

use const DATE_ATOM;

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
            User::createFromArray([
                'id'         => 1,
                'name'       => 'jill valentine',
                'email'      => 'valentine.jill@umbrella.com',
                'password'   => '12@Valentine',
            ]),
            User::createFromArray([
                'id'         => 2,
                'name'       => 'claire redfield',
                'email'      => 'claire.redfield@umbrella.com',
                'password'   => '12@Redfield',
            ]),
            User::createFromArray([
                'id'         => 3,
                'name'       => 'leon s. kennedy',
                'email'      => 'leon.kennedy@umbrella.com',
                'password'   => '12@Kennedy',
            ]),
        ];

        $this->userFactory($data);
        /** @var ViewModel $view */
        $view = $usecase->handle(InputModel::createFromArray([]));

        foreach ($view->toArray() as $k => $expected) {
            $this->assertSame($data[$k]->getId(), $expected['id']);
            $this->assertSame($data[$k]->getName(), $expected['name']);
            $this->assertSame($data[$k]->getEmail()->value(), $expected['email']);
            $this->assertSame((new DateTimeImmutable())->format(DATE_ATOM), $expected['created_at']);
            $this->assertNull($expected['updated_at']);
        }
    }
}
