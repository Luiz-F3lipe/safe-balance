<div class="p-6 sm:p-0">
    <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
        <div class="text-center lg:text-left mb-4 lg:mb-0">
            <h2 class="text-2xl font-bold">Contatos</h2>
            <p>Gerencie os contatos da sua conta</p>
        </div>
        <x-button icon="o-plus" class="btn-success w-full text-white lg:w-auto" wire:click="$dispatch('contacts::create')">
            Novo Contato
        </x-button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col-span-2">
            <x-input wire:model.live.debounce="search" icon="o-magnifying-glass" placeholder="Buscar por nome"
                class="w-full" />
        </div>
    </div>

    <x-table class="mt-6" :headers="$headers" :rows="$this->contacts" with-pagination per-page="quantity" :per-page-values="[5, 10, 25, 50]"
        no-scroll striped>
            @scope('cell_id', $contact)
                <span class="font-mono text-sm">{{ $contact->id }}</span>
            @endscope

            @scope('cell_name', $contact)
                <div class="font-medium">
                    {{ $contact->name }}
                </div>
            @endscope

            @scope('cell_created_at', $contact)
                {{ $contact->created_at->format('d/m/Y H:i') }}
            @endscope

            @scope('cell_actions', $contact)
                <div class="flex items-center gap-1 justify-center">
                    <x-button
                        class="btn-sm btn-ghost text-blue-600 hover:text-blue-800 hover:bg-blue-50"
                        wire:click="$dispatch('contacts::edit', { contact: {{ $contact }} })"
                        icon="lucide.pencil"
                        spinner
                        tooltip="Editar"
                    />

                    <x-button
                        class="btn-sm btn-ghost text-red-600 hover:text-red-800 hover:bg-red-50"
                        wire:click="$dispatch('contacts::destroy', { contact: {{ $contact }} })"
                        icon="lucide.trash"
                        spinner
                        tooltip="Excluir"
                    />
                </div>
            @endscope

            <x-slot:empty>
                <div class="flex flex-col items-center gap-3 py-10">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-500 flex items-center justify-center">
                        <x-icon name="lucide.contact" class="w-8 h-8" />
                    </div>
                    <div class="text-sm text-gray-500">Nenhum contato encontrado</div>

                    <p class="mt-1 text-sm">
                        @if ($search)
                            Nenhum contato corresponde à busca por "{{ $search }}"
                        @else
                            Crie um novo contato para começar a organizar suas informações
                        @endif
                    </p>

                    @if ($search)
                        <x-button
                            wire:click="cleanerFilter"
                            class="btn-outline btn-sm btn-success"
                        >
                            Limpar Filtros
                        </x-button>

                    @endif
                </div>
            </x-slot:empty>
    </x-table>

    <livewire:contact.create :key="uniqid()" />
    <livewire:contact.edit :key="uniqid()" />
    <livewire:contact.destroy :key="uniqid()" />
</div>
