<x-modal wire:model="showModal" title="Editar Contato" subtitle="Preencha os dados abaixo para editar o contato.">
    @if($contact)
        <div class="py-4">
            <form wire:submit.prevent="handle" class="space-y-4">
                <x-input label="Nome" wire:model="contact.name" />
            </form>
        </div>

        <x-slot:actions>
            <x-button label="Cancelar" wire:click="closeModal" class="btn-ghost" type="button" />
            <x-button
                wire:click="handle"
                label="Atualizar Contato"
                type="submit"
                class="btn-success text-white"
                spinner="handle"
                icon="o-plus"
            />
        </x-slot:actions>
    @endif
</x-modal>
