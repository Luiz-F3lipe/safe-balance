<div class="p-6 sm:p-0">
    <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
        <div class="text-center lg:text-left mb-4 lg:mb-0">
            <h2 class="text-2xl font-bold">Usuários</h2>
            <p>Gerencie os usuários da sua conta</p>
        </div>
        <x-button icon="o-plus" class="btn-success w-full text-white lg:w-auto" wire:click="$dispatch('users::create')">
            Novo Usuário
        </x-button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col-span-2">
            <x-input wire:model.live.debounce="search" icon="o-magnifying-glass" placeholder="Buscar por nome ou email"
                class="w-full" />
        </div>
    </div>

    <x-table class="mt-6" :headers="$headers" :rows="$this->users" with-pagination per-page="quantity" :per-page-values="[5, 10, 25, 50]"
        no-scroll striped>
            @scope('cell_id', $user)
                <span class="font-mono text-sm">{{ $user->id }}</span>
            @endscope

            @scope('cell_name', $user)
                <div class="font-medium">
                    {{ $user->name }}
                </div>
            @endscope

            @scope('cell_email', $user)
                <div class="text-sm text-gray-500">
                    {{ $user->email }}
                </div>
            @endscope

            @scope('cell_created_at', $user)
                <div class="text-sm text-gray-500">
                    {{ $user->created_at->format('d/m/Y H:i') }}
                </div>
            @endscope

            @scope('cell_actions', $user)
                <div class="flex items-center gap-1 justify-center">
                    <x-button
                        class="btn-sm btn-ghost text-red-600 hover:text-red-800 hover:bg-red-50"
                        wire:click="$dispatch('users::destroy', { id: {{ $user->id }} })"
                        icon="lucide.trash"
                        spinner
                        tooltip="Excluir"
                    />
                </div>
            @endscope

            <x-slot:empty>
                <div class="flex flex-col items-center gap-3 py-10">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-500 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 13h6m-3 -3v6m5 5H7a2 2 0 01-2 -2V5a2 2 0 012 -2h5.586a1 1 0 01.707 .293l5.414 5.414a1 1 0 01.293 .707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="text-sm text-gray-500">Nenhum usuário encontrado</div>
                </div>
            </x-slot:empty>
    </x-table>

    <livewire:user.create :key="uniqid()" />
    <livewire:user.destroy :key="uniqid()" />
</div>
