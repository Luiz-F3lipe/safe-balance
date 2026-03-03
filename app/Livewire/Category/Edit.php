<?php

declare(strict_types = 1);

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public bool $showModal = false;

    public Category $category;

    public array $typeOptions = [
        ['id' => 'income', 'name' => 'Receitas'],
        ['id' => 'expense', 'name' => 'Despesas'],
    ];

    #[On('categories::edit')]
    public function openModal(Category $category): void
    {
        $this->category  = $category;
        $this->showModal = true;
        $this->resetValidation();
    }

    public function rules(): array
    {
        return [
            'category.description' => ['required', 'string', 'max:255'],
            'category.type'        => ['required', 'in:income,expense'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.description.required' => 'A descrição é obrigatória.',
            'category.description.string'   => 'A descrição deve ser uma string.',
            'category.description.max'      => 'A descrição deve ter no máximo 255 caracteres.',
            'category.type.required'        => 'O tipo é obrigatório.',
            'category.type.in'              => 'O tipo deve ser "income" ou "expense".',
        ];
    }

    public function handle(): void
    {
        $this->validate();

        $this->category->save();

        $this->showModal = false;

        $this->dispatch('categories::refresh');

        $this->success('Categoria atualizada com sucesso!');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function render(): \Illuminate\Contracts\View\Factory | \Illuminate\Contracts\View\View
    {
        return view('livewire.category.edit');
    }
}
