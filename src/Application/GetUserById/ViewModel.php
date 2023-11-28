<?php

declare(strict_types=1);

namespace Application\GetUserById;

use Application\AbstractViewModel;
use JsonSerializable;

final class ViewModel extends AbstractViewModel implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $createdAt,
        public readonly string|null $updatedAt
    ) {
    }

    /**
     * @param array{
     *  id: int|null,
     *  name: string,
     *  email: string,
     *  created_at: string|null,
     *  updated_at: string|null
     * } $data
     */
    public static function createFromArray(?array $data = null): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['created_at'],
            $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'created_at'    => $this->createdAt,
            'updated_at'    => $this->updatedAt,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->formatter($this->toArray());
    }

    /**
     * @param mixed[] $payload
     */
    private function formatter(array $payload): array
    {
        return ['data' => $payload];
    }
}
