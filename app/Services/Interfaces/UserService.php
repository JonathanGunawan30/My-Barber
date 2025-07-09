<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface UserService
{
    public function getAll();

    public function find(int $id): User;

    public function create(array $data): User;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool | string;

    public function updateStatus(User $user, array $data): bool;
}
