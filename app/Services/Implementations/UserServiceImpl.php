<?php

namespace App\Services\Implementations;

use App\Models\User;
use App\Services\Interfaces\UserService;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
    public function getAll()
    {
        return User::all();
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);
        $isSelf = auth()->id() === $id;

        if ($isSelf && array_key_exists('status', $data) && $data['status'] !== $user->status) {
            return false;
        }

        return $user->update($data);
    }



    public function delete(int $id): bool | string
    {
        if (auth()->id() === $id) {
            return 'You cannot delete your own account.';
        }

        $user = $this->find($id);
        return $user->delete();
    }



    public function updateStatus(User $user, array $data): bool
    {
        if (auth()->id() === $user->id) {
            return false;
        }

        $user->status = $data['status'] ?? $user->status;
        return $user->save();
    }

}
