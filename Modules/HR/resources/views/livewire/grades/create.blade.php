<div class="max-w-3xl space-y-8">
    <div>
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('hr.grades.index')">
                {{ __('core::navigation.grades') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item disabled>
                {{ __('hr::grades.create.title') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <h1 class="text-xl font-semibold text-gray-900">
            {{ __('hr::grades.create.title') }}
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('hr::grades.create.description') }}
        </p>
    </div>

    <livewire:hr.grades.form />
</div>