<?php

declare(strict_types=1);

namespace Domain\Interfaces;

use Domain\Entities\User;

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
     * Soft delete users
     */
    public function delete(int $id): void;

    /**
     * Update User
     */
    public function update(User $user): void;
}
