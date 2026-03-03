<x-modal wire:model="showModal" title="Criar Usúario" subtitle="Preencha os dados abaixo para criar um novo usúario.">
    @if($user)
        <div class="py-4">
            <form wire:submit.prevent="handle" class="space-y-4">
                <x-input label="Nome" wire:model="user.name" />
                <x-input label="Email" wire:model="user.email" type="email" />
                <x-input label="Senha" wire:model="password" type="password" />
                <x-input label="Confirme a Senha" wire:model="password_confirmation" type="password" />
            </form>
        </div>

        <x-slot:actions>
            <x-button label="Cancelar" wire:click="closeModal" class="btn-ghost" type="button" />
            <x-button
                wire:click="handle"
                label="Criar Espécie"
                type="submit"
                class="btn-success text-white"
                spinner="handle"
                icon="o-plus"
            />
        </x-slot:actions>
    @endif
</x-modal>
