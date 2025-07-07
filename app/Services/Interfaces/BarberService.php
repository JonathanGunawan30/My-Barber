<?php

namespace App\Services\Interfaces;

use App\Models\Barber;

interface BarberService
{
    public function getAll();
    public function find($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function updateStatus(Barber $barber, $status): void;
}
