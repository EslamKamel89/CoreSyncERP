<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            {{ __('hr::hr.departments.title') }}
        </h2>

        <flux:button
            href="{{ route('hr.departments.create') }}"
            wire:navigate
            variant="primary">
            {{ __('hr::hr.departments.create') }}
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


    </div>
    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('hr::hr.departments.search_placeholder') }}"
        clearable />
    <x-core::shared.responsive-list :data="$this->departments['list']" />
    <div>
        {{ $this->departments['links'] }}
    </div>
</div>