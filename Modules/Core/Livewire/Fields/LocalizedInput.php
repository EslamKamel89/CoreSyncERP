<?php

namespace   Modules\Core\Livewire\Fields;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class LocalizedInput extends Component {
    const UPDATE = 'localized-input.updated';
    public array $value;
    public string $field;
    public string $label;
    #[Reactive]
    public ?string $error;
    public function mount(string $field, string $label, ?array $value = null, ?string $error = null) {
        $this->value = $value ?? [];
        $this->field = $field;
        $this->label = $label;
        $this->error = $error;
    }
    #[Computed]
    public function locales() {
        return config('core.locales.availableLocales');
    }
    public function updatedValue() {
        $this->dispatch(self::UPDATE, [
            'field' => $this->field,
            'value' => $this->value
        ]);
    }
    public function render() {
        return view('core::livewire.fields.localized-input');
    }
}
