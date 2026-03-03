<x-modal wire:model="showModal" title="Criar Categoria" subtitle="Preencha os dados abaixo para criar uma nova categoria.">
    @if($category)
        <div class="py-4">
            <form wire:submit.prevent="handle" class="space-y-4">
                <x-input label="Descrição" wire:model="category.description" />

                <x-select label="Tipo" wire:model="category.type" :options="$typeOptions" option-value="id" option-label="name" />
            </form>
        </div>

        <x-slot:actions>
            <x-button label="Cancelar" wire:click="closeModal" class="btn-ghost" type="button" />
            <x-button
                wire:click="handle"
                label="Criar Categoria"
                type="submit"
                class="btn-success text-white"
                spinner="handle"
                icon="o-plus"
            />
        </x-slot:actions>
    @endif
</x-modal>
