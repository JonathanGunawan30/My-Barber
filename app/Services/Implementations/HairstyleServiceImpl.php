<?php

namespace App\Services\Implementations;

use App\Models\Hairstyle;
use App\Services\Interfaces\HairstyleService;
use Illuminate\Support\Facades\Storage;

class HairstyleServiceImpl implements HairstyleService
{
    public function getAll()
    {
        return Hairstyle::all();
    }

    public function find($id)
    {
        return Hairstyle::findOrFail($id);
    }

    public function create(array $data)
    {
        if (isset($data['photo'])) {
            $data['photo'] = $data['photo']->store('hairstyles', 'public');
        }

        return Hairstyle::create($data);
    }

    public function update($id, array $data)
    {
        $hairstyle = $this->find($id);

        if (isset($data['photo'])) {
            if ($hairstyle->photo) {
                Storage::disk('public')->delete($hairstyle->photo);
            }
            $data['photo'] = $data['photo']->store('hairstyles', 'public');
        }

        return $hairstyle->update($data);
    }

    public function delete($id)
    {
        $hairstyle = $this->find($id);

        if ($hairstyle->photo) {
            Storage::disk('public')->delete($hairstyle->photo);
        }

        return $hairstyle->delete();
    }

    public function updateStatus(Hairstyle $hairstyle, bool $isFeatured): void
    {
        $hairstyle->is_featured = $isFeatured;
        $hairstyle->save();
    }
}
