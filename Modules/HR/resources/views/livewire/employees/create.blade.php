<div class="max-w-3xl space-y-8">
    <div>
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('hr.employees.index')">
                {{ __('core::navigation.employees') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item disabled>
                {{ __('hr::employees.create.title') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <h1 class="text-xl font-semibold text-gray-900">
            {{ __('hr::employees.create.title') }}
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('hr::employees.create.description') }}
        </p>
    </div>

    <livewire:hr.employees.form />
</div>