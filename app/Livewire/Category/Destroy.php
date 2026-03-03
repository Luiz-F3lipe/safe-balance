<?php

declare(strict_types = 1);

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Destroy extends Component
{
    use Toast;

    public bool $showModal = false;

    public ?Category $category = null;

    #[On('categories::destroy')]
    public function openModal(Category $category): void
    {
        $this->category  = $category;
        $this->showModal = true;
    }

    public function destroy(): void
    {
        if ($this->category instanceof Category) {
            $containsTransactions = $this->category->transactions()->exists();

            if ($containsTransactions) {
                $this->info('Não é possível excluir esta categoria porque ela está associada a transações.');
                $this->closeModal();

                return;
            }

            $this->category->delete();
            $this->success('Categoria excluída com sucesso.');
            $this->dispatch('categories::refresh');
            $this->closeModal();
        }
    }

    public function closeModal(): void
    {
        $this->category  = null;
        $this->showModal = false;
    }

    public function render(): View
    {
        return view('livewire.category.destroy');
    }
}
