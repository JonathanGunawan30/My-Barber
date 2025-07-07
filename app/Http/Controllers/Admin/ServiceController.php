<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Services\Interfaces\ServiceService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    protected ServiceService $serviceService;
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $services = $this->serviceService->getAll();

        return Inertia::render('admin/Services/Index', [
            'services' => $services,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/Services/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request): RedirectResponse
    {
        $this->serviceService->store($request->validated());

        return redirect()->route('admin.services.index')
        ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $service = $this->serviceService->getById($id);

        return Inertia::render('admin/Services/Show', [
            'service' => $service,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $service = $this->serviceService->getById($id);

        return Inertia::render('admin/Services/Edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id): RedirectResponse
    {
        $this->serviceService->update($request->validated(), $id);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->serviceService->delete($id);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
