<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory | \Illuminate\Contracts\View\View
    {
        return view('livewire.auth.register');
    }
}
