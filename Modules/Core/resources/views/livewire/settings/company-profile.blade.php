<div class="max-w-3xl space-y-8">
    <div>
        <h1 class="text-xl font-semibold text-gray-900">
            Company Profile
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Manage your company’s basic information and regional settings.
        </p>
    </div>
    <form wire:submit.prevent="save" class="space-y-6">
        <flux:input label="Company Name" wire:model.defer="form.name" error="form.name">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="Legal Name" wire:model.defer="form.legal_name" error="form.legal_name">
            <x-slot name="iconTrailing">
                <x-core::shared.optional />
            </x-slot>
        </flux:input>
        <flux:input label="Tax Number" wire:model.defer="form.tax_number" error="form.tax_number">
            <x-slot name="iconTrailing">
                <x-core::shared.optional />
            </x-slot>
        </flux:input>
        <flux:input label="Base Currency (*)" wire:model.defer="form.base_currency" error="form.base_currency">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="Timezone (*)" wire:model.defer="form.timezone" error="form.timezone">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="Language (*)" wire:model.defer="form.locale" error="form.locale">
            <x-slot name="iconTrailing">
                <x-core::shared.required />
            </x-slot>
        </flux:input>
        <flux:input label="Fiscal Year Start" wire:model.defer="form.fiscal_year_start" error="form.fiscal_year_start">
            <x-slot name="iconTrailing">
                <x-core::shared.optional />
            </x-slot>
        </flux:input>
        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">
                Save Changes
            </flux:button>
        </div>
    </form>
</div>