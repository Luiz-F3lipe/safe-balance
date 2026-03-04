<?php

declare(strict_types = 1);

namespace App\Livewire\Transaction;

use App\Models\Account;
use App\Models\TransactionInstallments;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    public ?string $search = null;

    public ?int $selectedMonth = null;

    public bool $showBalance = false;

    public array $monthOptions = [
        ['id' => 1, 'name' => 'Janeiro'],
        ['id' => 2, 'name' => 'Fevereiro'],
        ['id' => 3, 'name' => 'Março'],
        ['id' => 4, 'name' => 'Abril'],
        ['id' => 5, 'name' => 'Maio'],
        ['id' => 6, 'name' => 'Junho'],
        ['id' => 7, 'name' => 'Julho'],
        ['id' => 8, 'name' => 'Agosto'],
        ['id' => 9, 'name' => 'Setembro'],
        ['id' => 10, 'name' => 'Outubro'],
        ['id' => 11, 'name' => 'Novembro'],
        ['id' => 12, 'name' => 'Dezembro'],
    ];

    protected $listeners = [
        'transactions::refresh' => '$refresh',
    ];

    public function mount(): void
    {
        // Define mês atual como padrão
        $this->selectedMonth = (int) Carbon::now()->month;
    }

    #[Computed]
    public function currentAccount(): ?Account
    {
        return Auth::user()->account;
    }

    #[Computed]
    public function transactions(): Collection
    {
        $query = TransactionInstallments::with([
            'transaction.category',
            'transaction.contact',
            'transaction.account',
        ])->whereHas('transaction', function ($q) {
            $q->where('account_id', Auth::user()->account_id);
        });

        // Filtro por mês (usando due_date)
        if ($this->selectedMonth) {
            $year = Carbon::now()->year;
            $query->whereYear('due_date', $year)
                ->whereMonth('due_date', $this->selectedMonth);
        }

        // Busca por descrição ou contato
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('transaction', function ($transactionQuery) {
                    $transactionQuery->where('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('contact', function ($contactQuery) {
                            $contactQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            });
        }

        return $query->orderBy('due_date', 'desc')->get();
    }

    #[Computed]
    public function totalIncome(): float
    {
        $query = TransactionInstallments::whereHas('transaction', function ($q) {
            $q->where('account_id', Auth::user()->account_id)
                ->whereHas('category', function ($categoryQuery) {
                    $categoryQuery->where('type', 'income');
                });
        });

        // Filtro por mês (usando due_date)
        if ($this->selectedMonth) {
            $year = Carbon::now()->year;
            $query->whereYear('due_date', $year)
                ->whereMonth('due_date', $this->selectedMonth);
        }

        return $query->sum('amount');
    }

    #[Computed]
    public function totalExpense(): float
    {
        $query = TransactionInstallments::whereHas('transaction', function ($q) {
            $q->where('account_id', Auth::user()->account_id)
                ->whereHas('category', function ($categoryQuery) {
                    $categoryQuery->where('type', 'expense');
                });
        });

        // Filtro por mês (usando due_date)
        if ($this->selectedMonth) {
            $year = Carbon::now()->year;
            $query->whereYear('due_date', $year)
                ->whereMonth('due_date', $this->selectedMonth);
        }

        return $query->sum('amount');
    }

    #[Computed]
    public function balance(): float
    {
        return $this->totalIncome - $this->totalExpense;
    }

    public function updatedSelectedMonth(): void
    {
        unset($this->totalIncome, $this->totalExpense, $this->balance);
    }

    public function cleanerFilter(): void
    {
        $this->search        = null;
        $this->selectedMonth = (int) Carbon::now()->month;
    }

    public function toggleBalance(): void
    {
        $this->showBalance = ! $this->showBalance;
    }

    public function render(): View
    {
        return view('livewire.transaction.index');
    }
}
