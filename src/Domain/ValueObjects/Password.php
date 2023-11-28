<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

use InvalidArgumentException;
use Respect\Validation\Validator as v;
use Stringable;

use function password_hash;
use function password_verify;

use const PASSWORD_BCRYPT;

final class Password implements Stringable
{
    public function __construct(
        private string $password
    ) {
        if (!$this->isValid($password)) {
            throw new InvalidArgumentException('invalid password.', 404);
        }

        $this->password = $this->encrypt($password);
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->password;
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    private function encrypt(string $value): string
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    private function isValid(string $value): bool
    {
        $regex = '/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])(.{8,16})$/';

        return v::regex($regex)->validate($value);
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
