<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\Interfaces\ProfileAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class ProfileAdminController extends Controller
{
    protected ProfileAdminService $profileAdminService;

    public function __construct(ProfileAdminService $profileAdminService)
    {
        $this->profileAdminService = $profileAdminService;
    }

    public function edit(): Response
    {
        return Inertia::render('admin/Profile/Index');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileAdminService->update(auth()->id(), $request->validated());

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $updated = $this->profileAdminService->updatePassword(
            auth()->id(),
            $data['current_password'],
            Hash::make($data['password'])
        );

        if (!$updated) {
            return back()->with('error', 'The current password is incorrect.');
        }

        return back()->with('success', 'Password updated successfully.');
    }

}
