<?php

declare(strict_types=1);

namespace Tests\Unit\Infra\Persistence;

use Domain\Entities\User;
use Domain\ValueObjects\Email;
use Infra\Persistence\UserRepository;
use InvalidArgumentException;
use Tests\Support\Mysql;
use Tests\TestCase;

/**
 * @covers Infra\Persistence\UserRepository
 */
final class UserRepositoryTest extends TestCase
{
    use Mysql;

    public function testSaveUserAndFindById(): void
    {
        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $repository->save($user);

        $expected = $repository->findById(1);

        $this->assertSame($expected->getName(), $user->getName());
        $this->assertEquals($expected->getEmail(), $user->getEmail());
        $this->assertSame($expected->getEmail()->value(), $user->getEmail()->value());
    }

    public function testThrowExceptionIfUserNotFound(): void
    {
        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User 1002 not found.');
        $this->expectExceptionCode(404);

        $repository->findById(1002);
    }

    public function testThrowExceptionIfUserReceiveSoftDelete(): void
    {
        $pdo = $this->pdo();

        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $repository = new UserRepository($pdo);
        $repository->save($user);
        $repository->remove(1);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User 1 not found.');
        $this->expectExceptionCode(404);

        $repository->findById(1);
    }

    public function testThrowExceptionWhenUserByEmailReceiveSoftDelete(): void
    {
        $pdo = $this->pdo();

        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $repository = new UserRepository($pdo);
        $repository->save($user);
        $repository->remove(1);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('User %s not found.', $user->getEmail()->value()));
        $this->expectExceptionCode(404);

        $repository->findByEmail($user->getEmail());
    }

    public function testFindByEmail(): void
    {
        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $repository->save($user);

        $expected = $repository->findByEmail(Email::create('w@w.com.br'));

        $this->assertSame($expected->getName(), $user->getName());
    }

    public function testThrowExceptionIfEmailNotFound(): void
    {
        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $email = Email::create('w@w.com.br');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('User %s not found.', $email->value()));
        $this->expectExceptionCode(404);

        $repository->findByEmail($email);
    }

    public function testHasUserFromId(): void
    {
        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $repository->save($user);

        $this->assertTrue($repository->has(1));
        $this->assertFalse($repository->has(2));
    }

    public function testHasUserFromEmail(): void
    {
        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $repository->save($user);

        $this->assertTrue($repository->hasEmail($user->getEmail()));
        $this->assertFalse($repository->hasEmail(Email::create('jsilva@email.com')));
    }

    public function testDeleteUser(): void
    {
        $user = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $repository->save($user);
        $repository->remove(1);

        $this->assertFalse($repository->has(1));
    }

    public function testThrowExceptionIfUserNotFoundInDeleteUser(): void
    {
        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User 1002 not found.');
        $this->expectExceptionCode(404);

        $repository->remove(1002);
    }

    public function testUpdateUser(): void
    {
        $data = User::createFromArray([
            'name' => 'weliton',
            'email' => 'w@w.com.br',
        ]);

        $pdo = $this->pdo();
        $repository = new UserRepository($pdo);

        $repository->save($data);
        $user = $repository->findById(1);

        $user->withName('jose weliton da silva');
        $repository->update($user);


        $this->assertSame('jose weliton da silva', $user->getName());
    }
}
