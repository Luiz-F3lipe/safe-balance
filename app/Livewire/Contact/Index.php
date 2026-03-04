<?php

declare(strict_types = 1);

namespace App\Livewire\Contact;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public int $quantity = 10;

    public ?string $search = null;

    protected $listeners = [
        'contacts::refresh' => '$refresh',
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
            ['key' => 'created_at', 'label' => 'Criado em'],
            ['key' => 'actions', 'label' => 'Ações', 'class' => 'text-center'],
        ];
    }

    #[Computed]
    public function contacts(): LengthAwarePaginator
    {
        $query = Contact::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy('created_at', 'asc')->paginate($this->quantity);
    }

    public function cleanerFilter(): void
    {
        $this->resetPage();
        $this->search = null;
    }

    public function render(): View
    {
        return view('livewire.contact.index', [
            'headers' => $this->headers(),
        ]);
    }
}
