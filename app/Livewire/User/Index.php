<?php

declare(strict_types = 1);

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
    use WithPagination;
    use Toast;

    public int $quantity = 10;

    public ?string $search = null;

    protected $listeners = [
        'users::refresh' => '$refresh',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'email', 'label' => 'E-mail'],
            ['key' => 'created_at', 'label' => 'Criado em'],
            ['key' => 'actions', 'label' => 'Ações', 'class' => 'text-center'],
        ];
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        $query = User::query()->where('account_id', Auth::user()->account_id);

        if ($this->search) {
            $query->where('name', 'like', sprintf('%%%s%%', $this->search))
                ->orWhere('email', 'like', sprintf('%%%s%%', $this->search));
        }

        return $query->orderBy('created_at', 'desc')->paginate($this->quantity);
    }

    public function cleanerFilter(): void
    {
        $this->resetPage();
        $this->search = null;
    }

    public function render(): View
    {
        return view('livewire.user.index', [
            'headers' => $this->headers(),
        ]);
    }
}
