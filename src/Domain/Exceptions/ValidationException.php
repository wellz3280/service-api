<?php

declare(strict_types=1);

namespace Domain\Exceptions;

use Throwable;

final class ValidationException extends ServiceException
{
    public function __construct(string $message, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string[] $rules
     */
    public static function create(array $rules, int $code = 400): self
    {
        $self = new self('A validation has occurred, please see the rules field', $code);
        $self->withMetadata('rules', $rules);

        return $self;
    }
}
