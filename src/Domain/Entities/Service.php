<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;

final class Service extends AbstractEntity
{
    public function __construct(
        protected int|null $id,
        private string $name,
        private string $description,
        private string $console,
        private float $value,
        protected int|null $createdAt,
        protected int|null $deletedAt = null,
        protected int|null $updatedAt = null,
    ) {
    }

    /**
     * @param array{
     *  id: int|null,
     *  name: string,
     *  description: string,
     *  console: string,
     *  value: float,
     *  created_at?: int|null,
     *  deleted_at?: int|null,
     *  updated_at?: int|null
     * }$data
     */
    public static function createFromArray(array $data): self
    {
        $createdAt = $data['created_at'] ?? null;
        if (is_int($createdAt)) {
            $createdAt = (new DateTimeImmutable())->setTimestamp($createdAt)->getTimestamp();
        }

        return new self(
            $data['id'] ?? null,
            $data['name'],
            $data['description'],
            $data['console'],
            $data['value'],
            $createdAt,
            $data['deleted_at'] ?? null,
            $data['updated_at'] ?? null
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getConsole(): string
    {
        return $this->console;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
