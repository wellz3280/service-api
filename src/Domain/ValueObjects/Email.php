<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

use Domain\Exceptions\EmailException;
use JsonSerializable;
use Stringable;

final class Email implements Stringable, JsonSerializable
{
    private string $email;

    public function __construct(string $email)
    {
       if ($this->isValid($email)) {
           $this->email = $email;
        }
    }

    public function value(): string
    {
        return $this->email;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function equals(Email $email): bool
    {
        return $this->email === $email->value();
    }

    public function jsonSerialize(): mixed
    {
        return $this->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function isValid(string $value): bool
    {
        $patters    = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/';
        $validate   = preg_match($patters, $value);

        if (!$validate) {
            throw EmailException::invalidEmail('Email is not valid.');
        }

        return true;
    }
}
