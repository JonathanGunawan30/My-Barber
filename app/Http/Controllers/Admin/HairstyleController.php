<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHairstyleRequest;
use App\Http\Requests\UpdateHairstyleRequest;
use App\Http\Requests\UpdateHairstyleStatusRequest;
use App\Models\Hairstyle;
use App\Services\Interfaces\HairstyleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HairstyleController extends Controller
{
    protected HairstyleService $hairstyleService;
    public function __construct(HairstyleService $hairstyleService)
    {
        $this->hairstyleService = $hairstyleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $hairstyles = $this->hairstyleService->getAll();

        return Inertia::render('admin/Hairstyles/Index', [
            'hairstyles' => $hairstyles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/Hairstyles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateHairstyleRequest $request): RedirectResponse
    {
        $this->hairstyleService->create($request->validated());

        return redirect()->route('admin.hairstyles.index')
            ->with('success', 'Hairstyle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $hairstyle = $this->hairstyleService->find($id);

        return Inertia::render('admin/Hairstyles/Show', [
            'hairstyle' => $hairstyle,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $hairstyle = $this->hairstyleService->find($id);

        return Inertia::render('admin/Hairstyles/Edit', [
            'hairstyle' => $hairstyle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHairstyleRequest $request, int $id): RedirectResponse
    {
        $this->hairstyleService->update($id, $request->validated());

        return redirect()->route('admin.hairstyles.index')
            ->with('success', 'Hairstyle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->hairstyleService->delete($id);

        return redirect()->route('admin.hairstyles.index')
            ->with($deleted ? 'success' : 'error', $deleted
                ? 'Hairstyle deleted successfully.'
                : 'Failed to delete hairstyle.');
    }

    public function updateStatus(UpdateHairstyleStatusRequest $request, Hairstyle $hairstyle)
    {
        $isFeatured = $request->validated('is_featured');
        $this->hairstyleService->updateStatus($hairstyle, $isFeatured);
        return back()->with('success', 'Hairstyle status updated successfully.');
    }
}
