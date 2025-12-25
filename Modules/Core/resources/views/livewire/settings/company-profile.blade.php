<div class="max-w-3xl space-y-8">
    <div>
        <h1 class="text-xl font-semibold text-gray-900">
            {{ __('core::company-profile.title') }}
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('core::company-profile.description') }}
        </p>
    </div>
    <form wire:submit.prevent="save" class="space-y-6">
        <flux:input label="{{ __('core::company-profile.fields.name') }}" wire:model.defer="form.name" error="form.name">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="{{ __('core::company-profile.fields.legal_name') }}" wire:model.defer="form.legal_name" error="form.legal_name">
            <x-slot name="iconTrailing">
                <x-core::shared.optional />
            </x-slot>
        </flux:input>
        <flux:input label="{{ __('core::company-profile.fields.tax_number') }}" wire:model.defer="form.tax_number" error="form.tax_number">
            <x-slot name="iconTrailing">
                <x-core::shared.optional />
            </x-slot>
        </flux:input>
        <flux:input label="{{ __('core::company-profile.fields.base_currency') }} (*)" wire:model.defer="form.base_currency" error="form.base_currency">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="{{ __('core::company-profile.fields.timezone') }} (*)" wire:model.defer="form.timezone" error="form.timezone">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="{{ __('core::company-profile.fields.language') }} (*)" wire:model.defer="form.locale" error="form.locale">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="{{ __('core::company-profile.fields.fiscal_year_start') }}" wire:model.defer="form.fiscal_year_start" error="form.fiscal_year_start">
            <x-slot name="iconTrailing">
                <x-core::shared.optional />
            </x-slot>
        </flux:input>
        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">
                {{ __('core::company-profile.actions.save') }}
            </flux:button>
        </div>
    </form>
</div>