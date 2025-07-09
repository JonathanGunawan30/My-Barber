<?php

namespace App\Services\Implementations;

use App\Models\Testimonial;
use App\Services\Interfaces\TestimonialService;
use Illuminate\Support\Collection;

class TestimonialServiceImpl implements TestimonialService
{
    public function getAll(): Collection
    {
        return Testimonial::with(['customer', 'barber'])->get();
    }

    public function find(int $id): mixed
    {
        return Testimonial::findOrFail($id);
    }

    public function create(array $data): mixed
    {
        return Testimonial::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $testimonial = $this->find($id);
        return $testimonial->update($data);
    }

    public function delete(int $id): bool
    {
        $testimonial = $this->find($id);
        return $testimonial->delete();
    }
}
