<?php

namespace App\Services\Interfaces;

use App\Models\Branch;

interface BranchService
{
    function create($data);

    function update($id, $data);
    function delete($id);
    function getAll();
    function find($id);
    function updateStatus(Branch $branch, $status): void;
}
