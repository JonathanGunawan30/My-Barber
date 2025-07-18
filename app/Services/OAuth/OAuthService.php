<?php

namespace App\Services\OAuth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
interface OAuthService
{
    public function redirectToGoogle(): RedirectResponse;

    public function handleGoogleCallback(Request $request): RedirectResponse;

    public function loginManually(Request $request): RedirectResponse;
    public function registerManually(Request $request): RedirectResponse;
    public function logout(Request $request): RedirectResponse;

}
