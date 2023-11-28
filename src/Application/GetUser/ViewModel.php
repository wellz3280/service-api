<?php

declare(strict_types=1);

namespace Application\GetUser;

use Application\AbstractViewModel;
use JsonSerializable;

final class ViewModel extends AbstractViewModel implements JsonSerializable
{
    /**
     * @param mixed[] $users
     */
    public function __construct(
        public readonly array $users
    ) {
    }

    public static function createFromArray(?array $data = null): self
    {
        return new self($data ?? []);
    }

    public function jsonSerialize(): mixed
    {
        return $this->formatter($this->toArray());
    }

    public function toArray(): array
    {
        return $this->users;
    }

    /**
     * @param mixed[] $payload
     */
    private function formatter(array $payload): array
    {
        return ['data' => $payload];
    }
}
