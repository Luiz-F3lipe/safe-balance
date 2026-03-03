<?php

declare(strict_types = 1);

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public bool $showModal = false;

    public ?User $user = null;

    public string $password = '';

    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'user.name'  => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'user.name.required'  => 'O nome é obrigatório.',
            'user.email.required' => 'O email é obrigatório.',
            'user.email.email'    => 'O email deve ser um endereço de email válido.',
            'user.email.unique'   => 'Este email já está em uso.',
            'password.required'   => 'A senha é obrigatória.',
            'password.min'        => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed'  => 'A confirmação da senha não corresponde.',
        ];
    }

    #[On('users::create')]
    public function openModal(): void
    {
        $this->user      = new User();
        $this->showModal = true;
        $this->resetValidation();
    }

    public function handle(): void
    {
        $this->validate();

        $this->user->account_id = Auth::user()->account_id;
        $this->user->password   = $this->password;
        $this->user->save();

        $this->success('Usuário criado com sucesso!');

        $this->dispatch('users::refresh');
    }

    public function closeModal(): void
    {
        $this->showModal             = false;
        $this->user                  = null;
        $this->password              = '';
        $this->password_confirmation = '';
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.user.create');
    }
}
