<?php

namespace Modules\Core\Livewire\Filters;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class SelectFilter extends Component {
    const UPDATED = 'select-filter.updated';
    public string $name;
    public  $value = 'all';
    // options:[{'label':'Department', 'value':2}]
    #[Reactive]
    public array $options = [];
    public string  $label;
    public bool $showTaps = false;
    public function updatedValue(): void {
        $this->dispatch(self::UPDATED . '.' . $this->name, $this->value);
    }
    public function setValue($value = 'all'): void {
        $this->value = $value;
        $this->dispatch(self::UPDATED . '.' . $this->name, $this->value);
    }
    public function render() {
        return view('core::livewire.filters.select-filter');
    }
}
