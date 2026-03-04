<div class="p-6 sm:p-0">
    <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
        <div class="text-center lg:text-left mb-4 lg:mb-0">
            <h2 class="text-2xl font-bold">Categorias</h2>
            <p>Gerencie as categorias da sua conta</p>
        </div>
        <x-button icon="o-plus" class="btn-success w-full text-white lg:w-auto" wire:click="$dispatch('categories::create')">
            Nova Categoria
        </x-button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col-span-2">
            <x-input wire:model.live.debounce="search" icon="o-magnifying-glass" placeholder="Buscar por descrição"
                class="w-full" />
        </div>

        <div class="col-span-2 lg:col-span-1">
            <x-select wire:model.live="statusFilter" :options="$statusOptions" option-value="id" option-label="name"
                class="w-full" />
        </div>
    </div>

    <x-table class="mt-6" :headers="$headers" :rows="$this->categories" with-pagination per-page="quantity" :per-page-values="[5, 10, 25, 50]"
        no-scroll striped>
            @scope('cell_id', $category)
                <span class="font-mono text-sm">{{ $category->id }}</span>
            @endscope

            @scope('cell_description', $category)
                <div class="font-medium">
                    {{ $category->description }}
                </div>
            @endscope

            @scope('cell_type', $category)
                @php
                    $typeDescription = $category->type === 'income' ? 'Receita' : 'Despesa';
                    $typeColor = $category->type === 'income' ? 'badge-success' : 'badge-error';
                @endphp
                <x-badge :value="$typeDescription" :class="$typeColor" />
            @endscope

            @scope('cell_actions', $category)
                <div class="flex items-center gap-1 justify-center">
                    <x-button
                        class="btn-sm btn-ghost text-blue-600 hover:text-blue-800 hover:bg-blue-50"
                        wire:click="$dispatch('categories::edit', { id: {{ $category->id }} })"
                        icon="lucide.pencil"
                        spinner
                        tooltip="Editar"
                    />

                    <x-button
                        class="btn-sm btn-ghost text-red-600 hover:text-red-800 hover:bg-red-50"
                        wire:click="$dispatch('categories::destroy', { id: {{ $category->id }} })"
                        icon="lucide.trash"
                        spinner
                        tooltip="Excluir"
                    />
                </div>
            @endscope

            <x-slot:empty>
                <div class="flex flex-col items-center gap-3 py-10">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-500 flex items-center justify-center">
                        <x-icon name="lucide.tag" class="w-8 h-8" />
                    </div>
                    <div class="text-sm text-gray-500">Nenhuma categoria encontrada</div>

                    <p class="mt-1 text-sm">
                        @if ($search)
                            Nenhuma categoria corresponde à busca por "{{ $search }}"
                        @else
                            Crie uma nova categoria para começar a organizar suas transações
                        @endif
                    </p>

                    @if ($search || $statusFilter !== 'all')
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

    <livewire:category.create :key="uniqid()" />
    <livewire:category.edit :key="uniqid()" />
    <livewire:category.destroy :key="uniqid()" />
</div>
