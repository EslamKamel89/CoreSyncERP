<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            {{ __('hr::hr.positions.title') }}
        </h2>

        <flux:button
            href="{{ route('hr.positions.create') }}"
            wire:navigate
            variant="primary">
            {{ __('hr::hr.positions.create') }}
        </flux:button>
    </div>

    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('hr::hr.positions.search_placeholder') }}"
        clearable />

    <x-core::shared.responsive-list :data="$this->positions['list']" />

    <div>
        {{ $this->positions['links'] }}
    </div>
</div>