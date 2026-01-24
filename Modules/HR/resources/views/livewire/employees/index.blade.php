<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            {{ __('hr::hr.employees.title') }}
        </h2>

        <flux:button
            href="{{ route('hr.employees.create') }}"
            wire:navigate
            variant="primary">
            {{ __('hr::hr.employees.create') }}
        </flux:button>
    </div>
    <div
        class="w-full p-4 border rounded-xl shadow-sm bg-white flex flex-col gap-4">
        {{-- Top row: list mechanics --}}
        <div class="flex flex-wrap items-end gap-4">
            <livewire:core.filters.per-page-select />
            <livewire:core.filters.status-filter />
            <livewire:core.filters.sort-select :options="$sortOptions" />
        </div>

        {{-- Divider --}}
        <div class="h-px bg-gray-200"></div>

        {{-- Bottom row: domain filters --}}
        <div class="flex flex-wrap items-end gap-4">
            <livewire:core.filters.select-filter
                name="department_id"
                :label="__('core::navigation.departments')"
                :options="$departments"
                showTaps />

            <livewire:core.filters.select-filter
                name="position_id"
                :label="__('core::navigation.positions')"
                :options="$positions" />
        </div>
    </div>

    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('hr::hr.employees.search_placeholder') }}"
        clearable />

    <x-core::shared.responsive-list :data="$this->employees['list']" />

    {{-- Pagination --}}
    <div>
        {{ $this->employees['links'] }}
    </div>
</div>