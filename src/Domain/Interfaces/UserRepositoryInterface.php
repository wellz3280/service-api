<?php

declare(strict_types=1);

namespace Domain\Interfaces;

use Domain\Entities\User;
use Domain\ValueObjects\Email;

interface UserRepositoryInterface
{
    /**
     * Save user
     */
    public function save(User $user): void;

    /**
     * Get Uner by id
     */
    public function findById(int $id): User;

    /**
     * Get User by Email
     */
    public function findByEmail(Email $email): User;

    /**
     * Check if user exists from id
     */
    public function has(int $id): bool;

      /**
     * Check if user exists from email
     */
    public function hasEmail(Email $email): bool;

    /**
     * Soft delete users
     */
    public function remove(int $id): void;

    /**
     * Update User
     */
    public function update(User $user): void;
}
