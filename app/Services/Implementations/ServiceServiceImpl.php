<?php

namespace App\Services\Implementations;

use App\Models\Service;
use App\Services\Interfaces\ServiceService;
use Illuminate\Support\Facades\Storage;

class ServiceServiceImpl implements ServiceService
{
    public function getAll()
    {
        return Service::all();
    }

    public function store($request)
    {
        if (isset($request['photo'])) {
            $request['photo'] = $request['photo']->store('services', 'public');
        }

        return Service::create($request);
    }


    public function getById($id)
    {
        return Service::findOrFail($id);
    }

    public function update($request, $id)
    {
        $service = Service::findOrFail($id);

        if (isset($request['photo'])) {
            if ($service->photo && Storage::disk('public')->exists($service->photo)) {
                Storage::disk('public')->delete($service->photo);
            }
            $request['photo'] = $request['photo']->store('services', 'public');
        } else {
            $request['photo'] = $service->photo;
        }

        $service->update([
            'name' => $request['name'] ?? $service->name,
            'price' => $request['price'] ?? $service->price,
            'duration' => $request['duration'] ?? $service->duration,
            'photo' => $request['photo'],
            'description' => $request['description'] ?? $service->description,
        ]);

        return $service;
    }


    public function delete($id)
    {
        return Service::destroy($id);
    }
}
