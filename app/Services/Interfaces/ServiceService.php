<?php

namespace App\Services\Interfaces;

interface ServiceService
{
    function getAll();
    public function store($request);
    public function getById($id);
    public function update($request, $id);
    public function delete($id);
}
