<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            {{ __('core::roles.title') }}
        </h2>

        <flux:button
            href="{{ route('core.roles.create') }}"
            wire:navigate
            variant="primary">
            {{ __('core::roles.create.title') }}
        </flux:button>
    </div>

    {{-- List mechanics container --}}
    <div class="w-full p-4 border rounded-xl shadow-sm bg-white flex flex-col gap-4">

        {{-- Top row: list mechanics --}}
        <div class="flex flex-wrap items-end gap-4">
            <livewire:core.filters.per-page-select />
            <livewire:core.filters.sort-select :options="$sortOptions" />
        </div>

    </div>

    {{-- Search --}}
    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('core::roles.search_placeholder') }}"
        clearable />

    {{-- Responsive list --}}
    <x-core::shared.responsive-list :data="$this->roles['list']" />

    {{-- Pagination --}}
    <div>
        {{ $this->roles['links'] }}
    </div>

</div>