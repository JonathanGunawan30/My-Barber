<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\BranchUpdateRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Branch;
use App\Services\Interfaces\BranchService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BranchController extends Controller
{
    protected BranchService $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $branches = $this->branchService->getAll();

        return Inertia::render('admin/Branches/Index', [
            'branches' => $branches,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/Branches/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request): RedirectResponse
    {
        $this->branchService->create($request->validated());

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $branch = $this->branchService->find($id);

        return Inertia::render('admin/Branches/Show', [
            'branch' => $branch,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $branch = $this->branchService->find($id);

        return Inertia::render('admin/Branches/Edit', [
            'branch' => $branch,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchUpdateRequest $request, $id): RedirectResponse
    {
        $this->branchService->update($id, $request->validated());

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $this->branchService->delete($id);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }

    public function updateStatus(UpdateStatusRequest $request, Branch $branch)
    {
        $this->branchService->updateStatus($branch, $request->validated());

        return back()->with('success', 'Branch status updated successfully.');
    }

}
