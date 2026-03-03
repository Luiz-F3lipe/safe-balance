<?php

declare(strict_types = 1);

namespace App\Livewire\Category;

use App\Models\Category;
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

    public string $statusFilter = 'all';

    public array $statusOptions = [
        ['id' => 'all', 'name' => 'Todos'],
        ['id' => 'income', 'name' => 'Receitas'],
        ['id' => 'expense', 'name' => 'Despesas'],
    ];

    protected $listeners = [
        'categories::refresh' => '$refresh',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function headers(): array
    {
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'description', 'label' => 'Descrição'],
        ];

        if ($this->statusFilter === 'all') {
            $headers[] = ['key' => 'type', 'label' => 'Tipo'];
        }

        $headers[] = ['key' => 'actions', 'label' => 'Ações', 'class' => 'text-center'];

        return $headers;
    }

    #[Computed]
    public function categories(): LengthAwarePaginator
    {
        $query = Category::query();

        if ($this->search) {
            $query->where('description', 'like', sprintf('%%%s%%', $this->search));
        }

        if ($this->statusFilter === 'income') {
            $query->where('type', 'income');
        } elseif ($this->statusFilter === 'expense') {
            $query->where('type', 'expense');
        }

        return $query->orderBy('created_at', 'desc')->paginate($this->quantity);
    }

    public function cleanerFilter(): void
    {
        $this->resetPage();
        $this->search       = null;
        $this->statusFilter = 'all';
    }

    public function render(): View
    {
        return view('livewire.category.index', [
            'headers' => $this->headers(),
        ]);
    }
}
