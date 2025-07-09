<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface TestimonialService
{
    public function getAll(): Collection;
    public function find(int $id): mixed;
    public function create(array $data): mixed;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
