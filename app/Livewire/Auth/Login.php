<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'O campo e-mail deve conter um endereço de e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string'   => 'O campo senha deve ser uma string.',
            'password.min'      => 'O campo senha deve ter no mínimo 4 caracteres.',
        ];
    }

    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (Auth::attempt([
            'email'    => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            RateLimiter::clear($this->throttleKey());

            session()->regenerate();

            $this->redirectRoute('home');
        }

        RateLimiter::hit($this->throttleKey());

        $this->reset('password');
        $this->addError('email', 'E-mail ou senha inválidos.');
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());
        $minutes = ceil($seconds / 60);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => $minutes,
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
