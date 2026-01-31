<?php

namespace Modules\HR\Livewire\Grades;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Core\Livewire\Fields\LocalizedInput;
use Modules\Core\Traits\NotifiesWithToast;
use Modules\HR\Models\Department;
use Modules\HR\Models\Grade;
use Modules\HR\Models\Position;

class Form extends Component {
    use NotifiesWithToast;
    public const SAVED = 'grade-form.saved';

    public ?Grade $grade = null;

    public array $name = [];
    public ?float $base_salary = null;
    public bool $is_active = true;
    public function mount(): void {
        if ($this->grade) {
            $this->name        = $this->grade->name ?? [];
            $this->base_salary = $this->grade->base_salary;
            $this->is_active   = $this->grade->is_active;
        }
    }
    #[On(LocalizedInput::UPDATE)]
    public function updateName(array $payload): void {
        if ($payload['field'] === 'name') {
            $this->name = $payload['value'];
        }
    }
    public function save(): void {
        $validated = $this->validate(
            rules: [
                'name'           => ['required', 'array'],
                'name.*'         => ['required', 'string', 'max:255'],
                'base_salary'    => ['nullable', 'numeric', 'min:0'],
                'is_active'      => ['boolean'],
            ],
            attributes: $this->validationAttributes()
        );
        if ($this->grade) {
            $this->grade->update($validated);
        } else {
            $this->grade = Grade::create($validated);
        }

        $this->notifySaved();
        $this->dispatch(self::SAVED, $this->grade->id);
    }
    protected function validationAttributes(): array {
        $attributes = [];

        foreach (array_keys(config('core.locales.availableLocales')) as $locale) {
            $attributes["name.$locale"] =
                __('hr::grades.fields.name') .
                ' (' . __('core::locales.' . $locale) . ')';
        }

        return array_merge($attributes, [
            'name' => __('hr::grades.fields.name'),
            'base_salary' => __('hr::grades.fields.base_salary'),
            'is_active'   => __('hr::grades.fields.is_active'),
        ]);
    }
    public function render() {
        return view('hr::livewire.grades.form');
    }
}
