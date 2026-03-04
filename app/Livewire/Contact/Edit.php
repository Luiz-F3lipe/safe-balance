<?php

declare(strict_types = 1);

namespace App\Livewire\Contact;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public bool $showModal = false;

    public Contact $contact;

    #[On('contacts::edit')]
    public function openModal(Contact $contact): void
    {
        $this->contact   = $contact;
        $this->showModal = true;
        $this->resetValidation();
    }

    public function rules(): array
    {
        return [
            'contact.name' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'contact.name.required' => 'O nome é obrigatório.',
            'contact.name.string'   => 'O nome deve ser uma string.',
            'contact.name.min'      => 'O nome deve ter no mínimo 3 caracteres.',
            'contact.name.max'      => 'O nome deve ter no máximo 255 caracteres.',
        ];
    }

    public function handle(): void
    {
        $this->validate();

        $this->contact->save();

        $this->closeModal();

        $this->dispatch('contacts::refresh');
        $this->success('Contato atualizado com sucesso!');
    }

    public function closeModal(): void
    {
        $this->resetValidation();
        $this->showModal = false;
    }

    public function render(): View
    {
        return view('livewire.contact.edit');
    }
}
