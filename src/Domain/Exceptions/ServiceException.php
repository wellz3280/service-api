<?php

declare(strict_types=1);

namespace Domain\Exceptions;

use Exception;
use Throwable;

class ServiceException extends Exception
{
    private array $metadata = [];

    public function __construct(string $message, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function withMetadata(string $key, mixed $value): void
    {
        $this->metadata[$key] = $value;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }
}
