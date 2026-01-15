<div class="max-w-3xl space-y-8">
    <div>
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('hr.positions.index')">{{ __('core::navigation.positions') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item disabled>{{ __('hr::positions.create.title') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <h1 class="text-xl font-semibold text-gray-900">
            {{ __('hr::positions.create.title') }}
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('hr::positions.create.description') }}
        </p>
    </div>
    <livewire:hr.positions.form />
</div>