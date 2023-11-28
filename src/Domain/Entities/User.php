<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;
use Domain\ValueObjects\Email;

use function is_int;
use function is_string;

final class User extends AbstractEntity
{
    public function __construct(
        protected int|null $id,
        private string $name,
        private Email $email,
        protected int|null $createdAt,
        protected int|null $deletedAt,
        protected int|null $updatedAt,
    ) {
    }

    /**
     * @param array{
     * id?: int|null,
     * name: string,
     * email: Email,
     * created_at: int|null,
     * deleted_at?: int|null,
     * updated_at?: int|null
     * }$data
     */
    public static function createFromArray(array $data): self
    {
        $email = $data['email'];
        if (is_string($email)) {
            $email = Email::create($data['email']);
        }

        $createdAt = $data['created_at'] ?? null;
        if (is_int($createdAt)) {
            $createdAt = (new DateTimeImmutable())->setTimestamp($createdAt)->getTimestamp();
        }

        return new self(
            $data['id'] ?? null,
            $data['name'],
            $email,
            $createdAt ?? (new DateTimeImmutable())->getTimestamp(),
            $data['deleted_at'] ?? null,
            $data['updated_at'] ?? null,
        );
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
            return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email->value(),
            'created_at' => $this->createdAt,
            'deleted_at' => $this->deletedAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
