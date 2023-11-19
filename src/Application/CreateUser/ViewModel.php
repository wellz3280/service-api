<?php

declare(strict_types=1);

namespace Application\CreateUser;

use Application\AbstractViewModel;
use JsonSerializable;

final class ViewModel extends AbstractViewModel implements JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $createdAt,
    ) {
    }

    /**
     * @param array{
     *  name:string,
     *  email: string,
     * }$data
     */
    public static function createFromArray(?array $data = null): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['created_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => $this->createdAt,
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
