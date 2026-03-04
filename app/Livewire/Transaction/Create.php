<?php

declare(strict_types = 1);

namespace App\Livewire\Transaction;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public function render(): View
    {
        return view('livewire.transaction.create');
    }
}
