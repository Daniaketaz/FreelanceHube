<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
 use Illuminate\Validation\ValidationException;
class RefreshTokenRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'refresh_token'=>['string','required']
        ];
    }

    public function validateRefreshRequest(): void
    {
        $this->ensureIsNotRateLimited();

        RateLimiter::hit(
            $this->throttleKey(),
            60
        );
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts(
            $this->throttleKey(),
            10
        )) {
            return;
        }

        $seconds = RateLimiter::availableIn(
            $this->throttleKey()
        );

        throw ValidationException::withMessages([
            'refresh_token' => [
                "Too many refresh attempts. Try again after {$seconds} seconds."
            ]
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::lower(
            $this->ip()
        );
    }
}
