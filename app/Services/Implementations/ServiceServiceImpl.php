<?php

namespace App\Services\Implementations;

use App\Models\Service;
use App\Services\Interfaces\ServiceService;

class ServiceServiceImpl implements ServiceService
{
    public function getAll()
    {
        return Service::all();
    }

    public function store($request)
    {
        return Service::create($request);
    }


    public function getById($id)
    {
        return Service::findOrFail($id);
    }

    public function update($request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request['name'] ?? $service->name,
            'price' => $request['price'] ?? $service->price,
            'duration' => $request['duration'] ?? $service->duration,
        ]);
        return $service;
    }


    public function delete($id)
    {
        return Service::destroy($id);
    }
}
