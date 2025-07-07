<?php

namespace App\Services\Implementations;

use App\Models\Branch;
use App\Services\Interfaces\BranchService;

class BranchServiceImpl implements BranchService
{
    public function create($data)
    {
        if (request()->hasFile('photo')) {
            $data['photo'] = request()->file('photo')->store('branches', 'public');
        }

        return Branch::create($data);
    }

    public function update($id, $data)
    {
        $branch = $this->find($id);

        if (request()->hasFile('photo')) {
            $data['photo'] = request()->file('photo')->store('branches', 'public');
        }

        $branch->update($data);

        return $branch;
    }

    function delete($id)
    {
        $branch = Branch::findOrFail($id);
        return $branch->delete();
    }

    function getAll()
    {
        return Branch::latest()->get();
    }

    function find($id)
    {
        return Branch::findOrFail($id);
    }

    public function updateStatus(Branch $branch, $status): void
    {
        $branch->status = $status['status'];
        $branch->save();
    }
}
