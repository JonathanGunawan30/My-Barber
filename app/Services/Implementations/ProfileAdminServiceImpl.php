<?php

namespace App\Services\Implementations;

use App\Models\User;
use App\Services\Interfaces\ProfileAdminService;
use Illuminate\Support\Facades\Hash;

class ProfileAdminServiceImpl implements ProfileAdminService
{
    public function update(int $id, array $data): bool
    {
        $user = User::findOrFail($id);
        return $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function updatePassword(int $id, string $currentPassword, string $newHashedPassword): bool
    {
        $user = User::findOrFail($id);

        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $user->password = $newHashedPassword;
        return $user->save();
    }
}
