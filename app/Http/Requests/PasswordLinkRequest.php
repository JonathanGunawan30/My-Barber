<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
class PasswordLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'g-recaptcha-response' => ['required', 'string'],
        ];
    }

    public function passedValidation(): void
    {
        $this->validateRecaptcha();
    }

    protected function validateRecaptcha(): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret'),
            'response' => $this->input('g-recaptcha-response'),
            'remoteip' => $this->ip(),
        ]);

        $result = $response->json();

        if (! $result['success'] || ($result['score'] ?? 0) < 0.5 || ($result['action'] ?? '') !== 'forgot') {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['Failed reCAPTCHA verification.'],
            ]);
        }
    }
}
