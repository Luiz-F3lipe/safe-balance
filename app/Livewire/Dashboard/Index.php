<?php

declare(strict_types = 1);

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public string $startDate = '';

    public string $endDate = '';

    public function mount(): void
    {
        // Define o período padrão como o mês atual
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function getExpensesByCategoryProperty()
    {
        $accountId = Auth::user()->account_id;

        if (! $accountId) {
            return collect();
        }

        return DB::table('transaction_installments')
            ->join('transactions', 'transaction_installments.transaction_id', '=', 'transactions.id')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.account_id', $accountId)
            ->where('categories.type', 'expense')
            ->whereBetween('transaction_installments.due_date', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ])
            ->select(
                'categories.description as category',
                DB::raw('SUM(transaction_installments.amount) as total')
            )
            ->groupBy('categories.id', 'categories.description')
            ->get();
    }

    public function getExpensesByContactProperty()
    {
        $accountId = Auth::user()->account_id;

        if (! $accountId) {
            return collect();
        }

        return DB::table('transaction_installments')
            ->join('transactions', 'transaction_installments.transaction_id', '=', 'transactions.id')
            ->join('contacts', 'transactions.contact_id', '=', 'contacts.id')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.account_id', $accountId)
            ->where('categories.type', 'expense')
            ->whereBetween('transaction_installments.due_date', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ])
            ->select(
                'contacts.name as contact',
                DB::raw('SUM(transaction_installments.amount) as total')
            )
            ->groupBy('contacts.id', 'contacts.name')
            ->get();
    }

    public function getTotalExpensesProperty()
    {
        $accountId = Auth::user()->account_id;

        if (! $accountId) {
            return 0;
        }

        return DB::table('transaction_installments')
            ->join('transactions', 'transaction_installments.transaction_id', '=', 'transactions.id')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.account_id', $accountId)
            ->where('categories.type', 'expense')
            ->whereBetween('transaction_installments.due_date', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ])
            ->sum('transaction_installments.amount');
    }

    public function getTotalIncomeProperty()
    {
        $accountId = Auth::user()->account_id;

        if (! $accountId) {
            return 0;
        }

        return DB::table('transaction_installments')
            ->join('transactions', 'transaction_installments.transaction_id', '=', 'transactions.id')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.account_id', $accountId)
            ->where('categories.type', 'income')
            ->whereBetween('transaction_installments.due_date', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ])
            ->sum('transaction_installments.amount');
    }

    public function getMonthlyExpensesProperty()
    {
        $accountId = Auth::user()->account_id;

        if (! $accountId) {
            return collect();
        }

        // Busca gastos dos últimos 12 meses
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate   = Carbon::now()->endOfMonth();

        $data = DB::table('transaction_installments')
            ->join('transactions', 'transaction_installments.transaction_id', '=', 'transactions.id')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.account_id', $accountId)
            ->where('categories.type', 'expense')
            ->whereBetween('transaction_installments.due_date', [
                $startDate,
                $endDate,
            ])
            ->select(
                DB::raw("strftime('%Y-%m', transaction_installments.due_date) as month"),
                DB::raw('SUM(transaction_installments.amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Preenche meses sem dados com zero
        $result = collect();

        for ($i = 11; $i >= 0; $i--) {
            $month    = Carbon::now()->subMonths($i)->format('Y-m');
            $existing = $data->firstWhere('month', $month);

            $result->push([
                'month' => $month,
                'label' => Carbon::parse($month)->locale('pt_BR')->translatedFormat('M/y'),
                'total' => $existing ? (float) $existing->total : 0,
            ]);
        }

        return $result;
    }

    public function render(): View
    {
        return view('livewire.dashboard.index');
    }
}
