<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

use Domain\Exceptions\EmailException;
use JsonSerializable;
use Respect\Validation\Validator as v;
use Stringable;

final class Email implements Stringable, JsonSerializable
{
    private string $email;

    public function __construct(string $email)
    {
        if (!$this->isValid($email)) {
            throw EmailException::invalidEmail();
        }

        $this->email = $email;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function equals(Email $email): bool
    {
        return $this->email === $email->value();
    }

    public function jsonSerialize(): mixed
    {
        return $this->value();
    }

    private function isValid(string $value): bool
    {
        return v::email()->validate($value);
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
