<!-- Modal de Confirmação de Exclusão -->
<x-modal wire:model="showModal" title="Confirmar Exclusão" subtitle="Esta ação não pode ser revertida.">
    @if($user)
        <div class="py-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="shrink-0">
                    <x-icon name="o-trash" class="w-8 h-8 text-red-600" />
                </div>
                <div>
                    <p class="text-lg font-medium">Excluir Usuário</p>
                    <p class="text-gray-600">Tem certeza que deseja excluir o usuário "{{ $user->name }}"?</p>
                </div>
            </div>

            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-3 border border-red-200 dark:border-red-800">
                <p class="text-sm text-red-800 dark:text-red-200">
                    <strong>Atenção:</strong>
                    Esta ação é permanente e não poderá ser desfeita. Todos os dados deste usuário serão removidos do sistema.
                </p>
            </div>

            <div class="mt-4 bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    <strong>Detalhes:</strong><br>
                    Nome: {{ $user->name }}<br>
                    Email: {{ $user->email }}<br>
                    Criado em: {{ $user->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Cancelar" wire:click="closeModal" class="btn-ghost" />
            <x-button label="Excluir Usúario" wire:click="confirmDestroy" spinner="confirmDestroy"
                class="btn-error" icon="o-trash" />
        </x-slot:actions>
    @endif
</x-modal>
