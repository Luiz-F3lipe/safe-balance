<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Models\Account;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public Account $account;

    public User $user;

    public string $password = '';

    public string $password_confirmation = '';

    public bool $terms = false;

    public function mount(): void
    {
        $this->account = new Account();
        $this->user    = new User();
    }

    public function rules(): array
    {
        return [
            'account.name'          => ['required', 'string', 'max:50'],
            'user.name'             => ['required', 'string', 'max:50'],
            'user.email'            => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:4', 'confirmed'],
            'password_confirmation' => ['required'],
            'terms'                 => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'account.name.required'          => 'O nome da conta é obrigatório.',
            'account.name.string'            => 'O nome da conta deve ser uma string.',
            'account.name.max'               => 'O nome da conta não pode exceder 50 caracteres.',
            'user.name.required'             => 'O nome do usuário é obrigatório.',
            'user.name.string'               => 'O nome do usuário deve ser uma string.',
            'user.name.max'                  => 'O nome do usuário não pode exceder 50 caracteres.',
            'user.email.required'            => 'O e-mail é obrigatório.',
            'user.email.email'               => 'O e-mail deve ser um endereço de e-mail válido.',
            'user.email.max'                 => 'O e-mail não pode exceder 255 caracteres.',
            'user.email.unique'              => 'Este e-mail já está em uso.',
            'password.required'              => 'A senha é obrigatória.',
            'password.string'                => 'A senha deve ser uma string.',
            'password.min'                   => 'A senha deve ter pelo menos 4 caracteres.',
            'password.confirmed'             => 'As senhas não coincidem.',
            'password_confirmation.required' => 'A confirmação da senha é obrigatória.',
            'terms.accepted'                 => 'Você deve aceitar os termos e condições para se registrar.',
        ];
    }

    public function handle(): void
    {
        $this->validate();

        $this->account->save();

        $this->user->account_id = $this->account->id;
        $this->user->password   = $this->password;
        $this->user->save();

        Auth::login($this->user);

        $this->redirectRoute('home');
    }

    public function render(): View
    {
        return view('livewire.auth.register');
    }
}
