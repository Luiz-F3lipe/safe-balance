<?php

declare(strict_types = 1);

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Destroy extends Component
{
    use Toast;

    public bool $showModal = false;

    public ?int $userId = null;

    public ?User $user = null;

    #[On('users::destroy')]
    public function openModal(int $id): void
    {
        $this->userId    = $id;
        $this->user      = User::findOrFail($id);
        $this->showModal = true;
    }

    public function confirmDestroy(): void
    {
        if ($this->user instanceof User) {
            $this->user->delete();

            $this->success('Usuário deletado com sucesso!');

            $this->dispatch('users::refresh');
        }

        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->userId    = null;
        $this->user      = null;
    }

    public function render(): View
    {
        return view('livewire.user.destroy');
    }
}
