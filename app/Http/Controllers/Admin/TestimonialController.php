<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Barber;
use App\Models\Customer;
use App\Services\Interfaces\TestimonialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
{
    protected TestimonialService $testimonialService;
    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $testimonials = $this->testimonialService->getAll();
        $customers = Customer::all();
        $barbers = Barber::all();

        return Inertia::render('admin/Testimonials/Index', [
            'testimonials' => $testimonials,
            'customers' => $customers,
            'barbers' => $barbers,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/Testimonials/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTestimonialRequest $request): RedirectResponse
    {
        $this->testimonialService->create($request->validated());

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testimonial = $this->testimonialService->find($id);

        return Inertia::render('admin/Testimonials/Show', [
            'testimonial' => $testimonial,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $testimonial = $this->testimonialService->find($id);

        return Inertia::render('admin/Testimonials/Edit', [
            'testimonial' => $testimonial,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, string $id): RedirectResponse
    {
        $this->testimonialService->update($id, $request->validated());

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->testimonialService->delete($id);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}
