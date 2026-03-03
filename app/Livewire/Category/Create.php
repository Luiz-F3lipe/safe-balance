<?php

declare(strict_types = 1);

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public bool $showModal = false;

    public ?Category $category = null;

    public array $typeOptions = [
        ['id' => 'income', 'name' => 'Receitas'],
        ['id' => 'expense', 'name' => 'Despesas'],
    ];

    #[On('categories::create')]
    public function openModal(): void
    {
        $this->category       = new Category();
        $this->category->type = 'expense';

        $this->showModal = true;
    }

    public function rules(): array
    {
        return [
            'category.description' => ['required', 'string', 'max:60'],
            'category.type'        => ['required', 'in:income,expense'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.description.required' => 'A descrição é obrigatória.',
            'category.description.string'   => 'A descrição deve ser uma string.',
            'category.description.max'      => 'A descrição deve ter no máximo 60 caracteres.',
            'category.type.required'        => 'O tipo é obrigatório.',
            'category.type.in'              => 'O tipo deve ser "Receita" ou "Despesa".',
        ];
    }

    public function handle(): void
    {
        $this->validate();

        $this->category->save();

        $this->closeModal();

        $this->dispatch('categories::refresh');
        $this->success('Categoria criada com sucesso!');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->category  = null;
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.category.create');
    }
}
