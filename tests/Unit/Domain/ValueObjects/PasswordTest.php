<?php

declare(strict_types=1);

namespace tests\Unit\Domain\ValueObjects;

use Domain\ValueObjects\Password;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * @covers Domain\ValueObjects\Password;
*/
final class PasswordTest extends TestCase
{
    public function testInstantiatePasswordFromStaticMethod(): void
    {
        $pass     = '12@Weliton';
        $password = Password::create($pass);

        $this->assertTrue($password->verify($pass, $password->value()));
    }

    #[DataProvider('invalidPassword')]
    public function testThrowExceptionWhenPasswordNotValid(string $value): void
    {
        $this->expectExceptionMessage(InvalidArgumentException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('invalid password.');

        Password::create($value);
    }

    public static function invalidPassword(): array
    {
        return [
            'only lowercase characters'         => ['password@123'],
            'less than eight characters'        => ['pass23'],
            'greater than sixteen characters'   => ['Password@12345678'],
            'no uppercase characters'           => ['password@123'],
            'no special characters'             => ['Password123'],
            'just numbers'                      => ['12345678'],
        ];
    }
}
