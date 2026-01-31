<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            {{ __('hr::hr.grades.title') }}
        </h2>

        <flux:button
            href="{{ route('hr.grades.create') }}"
            wire:navigate
            variant="primary">
            {{ __('hr::hr.grades.create') }}
        </flux:button>
    </div>

    {{-- Filters Card --}}
    <div class="w-full p-4 border rounded-xl shadow-sm bg-white flex flex-col gap-4">
        <div class="flex flex-wrap items-end gap-4">
            <livewire:core.filters.per-page-select />
            <livewire:core.filters.status-filter />
            <livewire:core.filters.sort-select :options="$sortOptions" />
        </div>
    </div>

    {{-- Search --}}
    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('hr::hr.grades.search_placeholder') }}"
        clearable />

    {{-- List --}}
    <x-core::shared.responsive-list :data="$this->grades['list']" />

    {{-- Pagination --}}
    <div>
        {{ $this->grades['links'] }}
    </div>
</div>