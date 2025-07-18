<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OAuth\OAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    protected OAuthService $oAuthService;
    public function __construct(OAuthService $oAuthService)
    {
        $this->oAuthService = $oAuthService;
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return $this->oAuthService->redirectToGoogle();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        return $this->oAuthService->handleGoogleCallback($request);
    }

    public function loginManually(Request $request): RedirectResponse
    {
        return $this->oAuthService->loginManually($request);
    }

    public function registerManually(Request $request): RedirectResponse
    {
        return $this->oAuthService->registerManually($request);
    }

    public function logout(Request $request): RedirectResponse
    {
        return $this->oAuthService->logout($request);
    }


}
