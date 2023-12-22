<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;
use Domain\ValueObjects\Email;

use function is_int;
use function is_string;

final class Customer extends AbstractEntity
{
    public function __construct(
        protected int|null $id,
        private string $name,
        private Email $email,
        protected int|null $createdAt,
        protected int|null $deletedAt = null,
        protected int|null $updatedAt = null,
    ) {
    }

    /**
     * @param array{
     * id?: int|null,
     * name: string,
     * email: Email|string,
     * created_at?: int|null,
     * deleted_at?: int|null,
     * updated_at?: int|null
     * } $data
     */
    public static function createFromArray(array $data): self
    {
        $createdAt = $data['created_at'] ?? null;
        if (is_int($createdAt)) {
            $createdAt = (new DateTimeImmutable())->setTimestamp($createdAt)->getTimestamp();
        }

        $email = $data['email'];
        if (is_string($email)) {
            $email = Email::create($email);
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
}
