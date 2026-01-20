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

    {{-- Search --}}
    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('hr::hr.employees.search_placeholder') }}"
        clearable />

    {{-- List --}}
    <x-core::shared.responsive-list :data="$this->employees['list']" />

    {{-- Pagination --}}
    <div>
        {{ $this->employees['links'] }}
    </div>
</div>