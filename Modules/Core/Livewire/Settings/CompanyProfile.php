<?php

namespace Modules\Core\Livewire\Settings;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Modules\Core\Models\Company;
use Modules\Core\Traits\NotifiesWithToast;

class CompanyProfile extends Component {
    use AuthorizesRequests;
    use NotifiesWithToast;
    public ?Company $company;
    public array $form = [];
    public function mount(): void {
        $this->authorize('core.manage_settings');
        $this->company = Company::firstOrFail();
        $this->form = [
            'name' => $this->company->name,
            'legal_name' => $this->company->legal_name,
            'tax_number' => $this->company->tax_number,
            'base_currency' => $this->company->base_currency,
            'timezone' => $this->company->timezone,
            'locale' => $this->company->locale,
            'fiscal_year_start' => $this->company->fiscal_year_start,
        ];
    }
    public function save(): void {
        $validated = $this->validate(
            [
                'form.name' => ['required', 'string', 'max:255'],
                'form.legal_name' => ['nullable', 'string'],
                'form.tax_number' => ['nullable', 'string'],
                'form.base_currency' => ['required', 'string', 'size:3'],
                'form.timezone' => ['required', 'string'],
                'form.locale' => ['required', 'string'],
                'form.fiscal_year_start' => ['nullable', 'string'],
            ],
            [],
            [
                'form.name' => __('core::company-profile.fields.name'),
                'form.legal_name' => __('core::company-profile.fields.legal_name'),
                'form.tax_number' => __('core::company-profile.fields.tax_number'),
                'form.base_currency' => __('core::company-profile.fields.base_currency'),
                'form.timezone' => __('core::company-profile.fields.timezone'),
                'form.locale' => __('core::company-profile.fields.language'),
                'form.fiscal_year_start' => __('core::company-profile.fields.fiscal_year_start'),
            ]
        );
        $this->company->update($validated['form']);
        $this->notifySaved();
    }
    public function render(): View {
        return view('core::livewire.settings.company-profile');
    }
}
