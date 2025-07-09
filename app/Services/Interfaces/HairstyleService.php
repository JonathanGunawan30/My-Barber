<?php

namespace App\Services\Interfaces;

use App\Models\Hairstyle;

interface HairstyleService
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function updateStatus(Hairstyle $hairstyle, Bool $isFeatured): void;
}
