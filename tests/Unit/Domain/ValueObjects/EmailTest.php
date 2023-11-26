<?php

declare(strict_types=1);

namespace tests\Unit\Domain\ValueObjects;

use Domain\Exceptions\EmailException;
use Domain\ValueObjects\Email;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * @covers Domain\ValueObjects\Email
 */
final class EmailTest extends TestCase
{
    public function testInstantiateEmailFromStaticMethod(): void
    {
        $expected   = 'welingtonzsilva@gmail.com';
        $email      = Email::create($expected);

        $this->assertSame($expected, $email->value());
    }

    #[DataProvider('invalidEmail')]
    public function testThrowExceptionIfEmailIsNotValid(string $value): void
    {
        $this->expectExceptionMessage('Email is not valid.');
        $this->expectExceptionCode(400);
        $this->expectException(EmailException::class);
        Email::create($value);
    }

    public static function invalidEmail(): array
    {
        return [
            ['welingtonzsilvagmail.com'],
            ['welingtonzsilva@gmail'],
            ['welington z silva@gmail.com.br'],
            ['welington/silva@gmail.com.br'],
        ];
    }

    public function testEqualsWhenTheObjectWereTheSame(): void
    {
        $email      = 'welingtonzsilva@gmail.com';
        $emailOne   = Email::create($email);
        $emailTwo   = Email::create($email);

        $this->assertTrue($emailOne->equals($emailTwo));
    }

    public function testEqualsWhenTheObjectWereDiferent(): void
    {
        $email      = 'welingtonzsilva@gmail.com';
        $emailOne   = Email::create($email);
        $emailTwo   = Email::create('jvalentine@umbrella.com');

        $this->assertFalse($emailOne->equals($emailTwo));
    }
}