<?php

namespace App\Services\Interfaces;

interface ProfileAdminService
{
    public function update(int $id, array $data): bool;

    public function updatePassword(int $id, string $currentPassword, string $newHashedPassword): bool;
}
