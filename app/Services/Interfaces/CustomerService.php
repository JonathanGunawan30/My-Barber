<?php

namespace App\Services\Interfaces;

use App\Models\Customer;

interface CustomerService
{
    public function getAll(): array;
    public function find(int $id): ?Customer;
    public function create(array $data): Customer;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
