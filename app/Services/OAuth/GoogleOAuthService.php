<?php

namespace App\Services\OAuth;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Services\OAuth\OAuthService;

class GoogleOAuthService implements OAuthService
{
    public function redirectToGoogle(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request): \Illuminate\Http\RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $customer = Customer::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(str()->random(16)),
            ]
        );

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    public function loginManually(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors(['email' => 'Email or password is wrong.']);
    }

    public function registerManually(Request $request):  \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('success', 'Registration successful. Please login.');
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }

}
