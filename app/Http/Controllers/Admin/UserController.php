<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Models\User;
use App\Services\Interfaces\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = $this->userService->getAll();

        return Inertia::render('admin/Users/Index', [
            'users' => $users,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated());

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $user = $this->userService->find($id);

        return Inertia::render('admin/Users/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $user = $this->userService->find($id);

        return Inertia::render('admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $updated = $this->userService->update($user->id, $request->validated());

        if (!$updated) {
            return back()->with('error', 'You cannot change your own status.');
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $result = $this->userService->delete($user->id);

        if ($result !== true) {
            $message = is_string($result) ? $result : 'Cannot delete this user.';

            return redirect()->back()->with('error', $message);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }


    public function updateStatus(UpdateUserStatusRequest $request, User $user): RedirectResponse
    {
        $updated = $this->userService->updateStatus($user, $request->validated());

        if (!$updated) {
            return back()->with('error', 'You cannot change your own status.');
        }

        return back()->with('success', 'User status updated successfully.');
    }

}
