<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\ValueObjects\Email;

final class User extends AbstractEntity
{
    public function __construct(
        protected int $id,
        private string $name,
        private Email $email,
        protected int $createdAt,
        protected int|null $deletedAt,
        protected int|null $updatedAt,
    ) {
    }

    /**
     * @param array{
     * id: int,
     * name: string,
     * email: Email,
     * created_at: int,
     * deleted_at: int|null
     * updated_at: int|null
     * }$data
     */
    public static function createFromArray(array $data): self
    {
        $email = $data['email'];
        if (is_string($email)) {
            $email = Email::create($data['email']);
        }

        return new self(
            $data['id'],
            $data['name'],
            $email,
            $data['created_at'],
            $data['deleted_at'],
            $data['updated_at'],
        );
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
