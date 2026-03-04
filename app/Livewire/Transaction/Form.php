<?php

declare(strict_types = 1);

namespace App\Livewire\Transaction;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\TransactionInstallments;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Form extends Component
{
    use Toast;

    public ?Transaction $transaction = null;

    public int $installments = 1;

    public ?string $firstDueDate = null;

    public string $categorySearch = '';

    public string $contactSearch = '';

    public bool $categoryDropdownOpen = false;

    public bool $contactDropdownOpen = false;

    public function mount(?int $transactionId = null): void
    {
        if ($transactionId) {
            // Edição: busca a transação existente
            $this->transaction  = Transaction::with('installments')->findOrFail($transactionId);
            $this->installments = $this->transaction->installments;

            // Pega a data da primeira parcela
            $firstInstallment = $this->transaction->installments()->orderBy('installment')->first();

            if ($firstInstallment) {
                $this->firstDueDate = Carbon::parse($firstInstallment->due_date)->format('Y-m-d');
            }
        } else {
            // Criação: inicializa nova transação
            $this->transaction  = new Transaction();
            $this->installments = 1;
            $this->firstDueDate = Carbon::now()->format('Y-m-d');
        }
    }

    #[Computed]
    public function categories(): Collection
    {
        return Category::where('account_id', Auth::user()->account_id)
            ->orderBy('description')
            ->get();
    }

    #[Computed]
    public function contacts(): Collection
    {
        return Contact::where('account_id', Auth::user()->account_id)
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function filteredCategories(): Collection
    {
        $query = Category::where('account_id', Auth::user()->account_id);

        if ($this->categorySearch) {
            $query->where('description', 'like', '%' . $this->categorySearch . '%');
        }

        return $query->orderBy('description')->get();
    }

    #[Computed]
    public function filteredContacts(): Collection
    {
        $query = Contact::where('account_id', Auth::user()->account_id);

        if ($this->contactSearch) {
            $query->where('name', 'like', '%' . $this->contactSearch . '%');
        }

        return $query->orderBy('name')->get();
    }

    #[Computed]
    public function selectedCategory(): ?Category
    {
        return $this->transaction->category_id
            ? Category::find($this->transaction->category_id)
            : null;
    }

    #[Computed]
    public function selectedContact(): ?Contact
    {
        return $this->transaction->contact_id
            ? Contact::find($this->transaction->contact_id)
            : null;
    }

    public function selectCategory(int $categoryId): void
    {
        $this->transaction->category_id = $categoryId;
        $this->categoryDropdownOpen     = false;
        $this->categorySearch           = '';
    }

    public function clearCategory(): void
    {
        $this->transaction->category_id = null;
    }

    public function selectContact(int $contactId): void
    {
        $this->transaction->contact_id = $contactId;
        $this->contactDropdownOpen     = false;
        $this->contactSearch           = '';
    }

    public function clearContact(): void
    {
        $this->transaction->contact_id = null;
    }

    #[On('categories::created')]
    public function onCategoryCreated(int $categoryId): void
    {
        $this->transaction->category_id = $categoryId;
        unset($this->categories);
        unset($this->filteredCategories);
        unset($this->selectedCategory);
    }

    #[On('contacts::created')]
    public function onContactCreated(int $contactId): void
    {
        $this->transaction->contact_id = $contactId;
        unset($this->contacts);
        unset($this->filteredContacts);
        unset($this->selectedContact);
    }

    #[Computed]
    public function installmentAmount(): float
    {
        if (! $this->transaction?->amount || $this->installments < 1) {
            return 0;
        }

        return round($this->transaction->amount / $this->installments, 2);
    }

    public function rules(): array
    {
        return [
            'transaction.category_id' => ['required', 'exists:categories,id'],
            'transaction.contact_id'  => ['required', 'exists:contacts,id'],
            'transaction.description' => ['required', 'string', 'max:100'],
            'transaction.amount'      => ['required', 'numeric', 'min:0.01'],
            'installments'            => ['required', 'integer', 'min:1', 'max:360'],
            'firstDueDate'            => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'transaction.category_id.required' => 'A categoria é obrigatória.',
            'transaction.category_id.exists'   => 'Categoria inválida.',
            'transaction.contact_id.required'  => 'O contato é obrigatório.',
            'transaction.contact_id.exists'    => 'Contato inválido.',
            'transaction.description.required' => 'A descrição é obrigatória.',
            'transaction.description.string'   => 'A descrição deve ser uma string.',
            'transaction.description.max'      => 'A descrição deve ter no máximo 100 caracteres.',
            'transaction.amount.required'      => 'O valor é obrigatório.',
            'transaction.amount.numeric'       => 'O valor deve ser numérico.',
            'transaction.amount.min'           => 'O valor deve ser maior que zero.',
            'installments.required'            => 'O número de parcelas é obrigatório.',
            'installments.integer'             => 'O número de parcelas deve ser um número inteiro.',
            'installments.min'                 => 'Deve ter pelo menos 1 parcela.',
            'installments.max'                 => 'Não pode ter mais de 360 parcelas.',
            'firstDueDate.required'            => 'A data de vencimento é obrigatória.',
            'firstDueDate.date'                => 'A data de vencimento deve ser uma data válida.',
        ];
    }

    public function save(): void
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Criar ou atualizar a transação
            $this->transaction->installments = $this->installments;
            $this->transaction->save();

            // Se for edição, remove as parcelas antigas
            if ($this->transaction->wasRecentlyCreated === false) {
                $this->transaction->installments()->delete();
            }

            // Cria as parcelas
            $installmentAmount = $this->installmentAmount;
            $remainder         = $this->transaction->amount - ($installmentAmount * $this->installments);
            $firstDueDate      = Carbon::parse($this->firstDueDate);

            for ($i = 1; $i <= $this->installments; $i++) {
                $installment                 = new TransactionInstallments();
                $installment->transaction_id = $this->transaction->id;
                $installment->installment    = $i;

                // Adiciona o restante na última parcela
                if ($i === $this->installments && $remainder != 0) {
                    $installment->amount = $installmentAmount + $remainder;
                } else {
                    $installment->amount = $installmentAmount;
                }

                // Calcula a data de vencimento (adiciona meses) com hora atual
                $dueDate               = $firstDueDate->copy()->addMonths($i - 1);
                $installment->due_date = $dueDate->setTime(
                    Carbon::now()->hour,
                    Carbon::now()->minute,
                    Carbon::now()->second
                );
                $installment->save();
            }

            DB::commit();

            $isEdit  = $this->transaction->wasRecentlyCreated === false;
            $message = $isEdit ? 'Transação atualizada com sucesso!' : 'Transação criada com sucesso!';

            $this->success($message);
            $this->dispatch('transactions::refresh');
            $this->redirect(route('transactions.index'), navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Erro ao salvar transação. Tente novamente.');
        }
    }

    public function cancel(): void
    {
        $this->redirect(route('transactions.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.transaction.form');
    }
}
