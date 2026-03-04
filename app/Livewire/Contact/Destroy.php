<?php

declare(strict_types = 1);

namespace App\Livewire\Contact;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Destroy extends Component
{
    use Toast;

    public bool $showModal = false;

    public ?Contact $contact = null;

    #[On('contacts::destroy')]
    public function openModal(int $id): void
    {
        $this->contact   = Contact::findOrFail($id);
        $this->showModal = true;
    }

    public function destroy(): void
    {
        if ($this->contact instanceof Contact) {
            $containsTransactions = $this->contact->transactions()->exists();

            if ($containsTransactions) {
                $this->info('Não é possível excluir este contato porque ele está associado a transações.');
                $this->closeModal();

                return;
            }

            $this->contact->delete();
            $this->success('Contato excluído com sucesso.');
            $this->dispatch('contacts::refresh');
            $this->closeModal();
        }
    }

    public function closeModal(): void
    {
        $this->contact   = null;
        $this->showModal = false;
    }

    public function render(): View
    {
        return view('livewire.contact.destroy');
    }
}
