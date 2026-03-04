<?php

declare(strict_types = 1);

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Destroy extends Component
{
    use Toast;

    public bool $showModal = false;

    public ?Transaction $transaction = null;

    #[On('transactions::destroy')]
    public function openModal(int $id): void
    {
        $this->transaction = Transaction::findOrFail($id);
        $this->showModal   = true;
    }

    public function destroy(): void
    {
        if ($this->transaction instanceof Transaction) {
            $this->transaction->delete();

            $this->dispatch('transactions::refresh');
            $this->closeModal();
            $this->success('Transação excluída com sucesso!');
        } else {
            $this->error('Transação não encontrada.');
        }
    }

    public function closeModal(): void
    {
        $this->showModal   = false;
        $this->transaction = null;
    }

    public function render(): View
    {
        return view('livewire.transaction.destroy');
    }
}
