<?php

declare(strict_types=1);

namespace Domain\Exceptions;

use Throwable;

final class EmailException extends ServiceException
{
    public function __construct(string $message, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function emailExists(): self
    {
        return new self('Email already exists.');
    }

    public static function invalidEmail(): self
    {
        return new self('Email is not valid.');
    }
}
