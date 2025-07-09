<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\BarberService;

use App\Models\Barber;
use Illuminate\Support\Facades\Storage;

class BarberServiceImpl implements BarberService
{
    public function getAll()
    {
        return Barber::with('branch')->get();
    }

    public function find($id)
    {
        return Barber::with('branch')->findOrFail($id);
    }

    public function store(array $data)
    {
        if (isset($data['photo'])) {
            $data['photo'] = $data['photo']->store('barber', 'public');
        }

        return Barber::create($data);
    }

    public function update(array $data, $id)
    {
        $barber = Barber::findOrFail($id);

        if (isset($data['photo'])) {
            if ($barber->photo) {
                Storage::disk('public')->delete($barber->photo);
            }
            $data['photo'] = $data['photo']->store('barber', 'public');
        }

        $barber->update($data);
        return $barber;
    }

    public function delete($id): bool
    {
        $barber = Barber::findOrFail($id);

        if ($barber->bookings()->exists() || $barber->testimonials()->exists()) {
            return false;
        }

        if ($barber->photo) {
            Storage::disk('public')->delete($barber->photo);
        }

        return $barber->delete();
    }


    public function updateStatus(Barber $barber, $status): void
    {
        $barber->status = $status['status'];
        $barber->save();
    }
}

