<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBarberRequest;
use App\Http\Requests\UpdateBarberRequest;
use App\Http\Requests\UpdateBarberStatusRequest;
use App\Models\Barber;
use App\Models\Branch;
use App\Services\Interfaces\BarberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BarberController extends Controller
{
    protected BarberService $barberService;
    public function __construct(BarberService $barberService)
    {
        $this->barberService = $barberService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $barbers = $this->barberService->getAll();
        $branches = Branch::all();
        return Inertia::render('admin/Barbers/Index', compact('barbers', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $branches = Branch::all();

        return Inertia::render('admin/Barbers/Create', [
            'branches' => $branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBarberRequest $request): RedirectResponse
    {
        $this->barberService->store($request->validated());
        return redirect()->route('admin.barbers.index')->with('success', 'Barber created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $barber = $this->barberService->find($id);
        $branches = Branch::all();

        return Inertia::render('admin/Barbers/Show', [
            'barber' => $barber,
            'branches' => $branches,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $barber = $this->barberService->find($id);
        $branches = Branch::all();
        return Inertia::render('admin/Barbers/Edit', compact('barber', 'branches'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarberRequest $request, string $id): RedirectResponse
    {
        $this->barberService->update($request->validated(), $id);
        return redirect()->route('admin.barbers.index')->with('success', 'Barber updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->barberService->delete($id);
        return redirect()->route('admin.barbers.index')->with('success', 'Barber deleted successfully.');
    }

    public function updateStatus(UpdateBarberStatusRequest $request, Barber $barber)
    {
        $this->barberService->updateStatus($barber, $request->validated());

        return back()->with('success', 'Barber status updated successfully.');
    }
}
