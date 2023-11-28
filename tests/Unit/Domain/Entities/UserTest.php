<?php

declare(strict_types=1);

namespace tests\Unit\Domain\Entities;

use DateTimeImmutable;
use Domain\Entities\User;
use Domain\ValueObjects\Email;
use Tests\TestCase;

use const DATE_ATOM;

/**
 * @covers Domain\Entities\User
 */
final class UserTest extends TestCase
{
    public function testInstanceUserFromStaticMethod(): void
    {
        $expected = [
            'id'         => 1,
            'name'       => 'josé weliton da silva',
            'email'      => 'we@w.com.br',
            'created_at' => (new DateTimeImmutable())->getTimestamp(),
            'deleted_at' => null,
            'updated_at' => null,
        ];

        $user = User::createFromArray($expected);

        $this->assertSame($expected['id'], $user->getId());
        $this->assertSame($expected['name'], $user->getName());
        $this->assertSame($expected['email'], $user->getEmail()->value());
        $this->assertSame($expected['created_at'], $user->getCreatedAtFromTimeStanp());
        $this->assertSame((new DateTimeImmutable())->format(DATE_ATOM), $user->getCreatedAt());
        $this->assertNull($user->getDeletedAt());
        $this->assertNull($user->getUpdatedAt());
        $this->assertSame($expected, $user->toArray());
    }

    public function testInstantiateUserWithEmailObject(): void
    {
        $expected = [
            'id'         => 1,
            'name'       => 'josé weliton da silva',
            'email'      => Email::create('we@w.com.br'),
            'created_at' => (new DateTimeImmutable())->getTimestamp(),
            'deleted_at' => null,
            'updated_at' => null,
        ];

        $user = User::createFromArray($expected);

        $this->assertSame($expected['email'], $user->getEmail());
    }

    public function testInstantiateUserwithoutOptionalproperties(): void
    {
        $expected = [
            'id'         => 1,
            'name'       => 'josé weliton da silva',
            'email'      => Email::create('we@w.com.br'),
        ];

        $user = User::createFromArray($expected);

        $this->assertSame($expected['id'], $user->getId());
    }
}
