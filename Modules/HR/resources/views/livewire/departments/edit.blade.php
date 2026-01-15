<div class="max-w-3xl space-y-8">
    <div>
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('hr.departments.index')">{{ __('core::navigation.departments') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item disabled>{{ __('hr::departments.edit.title') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <h1 class="text-xl font-semibold text-gray-900">
            {{ __('hr::departments.edit.title') }}
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('hr::departments.edit.description') }}
        </p>
    </div>
    <livewire:hr.departments.form :department="$department" />
</div>