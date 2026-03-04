<?php

declare(strict_types = 1);

namespace App\Livewire\Contact;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public bool $showModal = false;

    public ?Contact $contact = null;

    #[On('contacts::create')]
    public function openModal(): void
    {
        $this->contact = new Contact();

        $this->showModal = true;
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

        $this->success('Contato criado com sucesso!');
        $this->dispatch('contacts::refresh');

        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->contact   = null;
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.contact.create');
    }
}
