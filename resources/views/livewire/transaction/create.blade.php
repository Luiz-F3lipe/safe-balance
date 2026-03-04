<div class="p-4 sm:p-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Nova Transação
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Preencha os dados abaixo para criar uma nova transação.
                </p>
            </div>
        </div>
    </div>

    {{-- Form Component --}}
    <livewire:transaction.form />

    {{-- Modals --}}
    <livewire:contact.create :key="uniqid()" />
    <livewire:category.create :key="uniqid()" />
</div>
