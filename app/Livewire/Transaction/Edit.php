<?php

declare(strict_types = 1);

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    public Transaction $transaction;

    public function mount(int $id): void
    {
        $this->transaction = Transaction::findOrFail($id);
    }

    public function render(): View
    {
        return view('livewire.transaction.edit');
    }
}
