<?php

namespace App\Services\Implementations;
use App\Models\Customer;
use App\Services\Interfaces\CustomerService;
use Illuminate\Support\Facades\Hash;

class CustomerServiceImpl implements CustomerService
{
    public function getAll(): array
    {
        return Customer::all()->toArray();
    }

    public function find(int $id): ?Customer
    {
        return Customer::find($id);
    }

    public function create(array $data): Customer
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return Customer::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $customer = $this->find($id);

        if (!$customer) return false;

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $customer->update($data);
    }

    public function delete(int $id): bool
    {
        $customer = $this->find($id);

        if (!$customer) {
            return false;
        }

        if ($customer->bookings()->exists() || $customer->testimonials()->exists()) {
            return false;
        }

        return $customer->delete();
    }

}

