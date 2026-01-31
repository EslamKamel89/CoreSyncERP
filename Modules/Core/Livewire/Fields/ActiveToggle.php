<?php

namespace Modules\Core\Livewire\Fields;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class ActiveToggle extends Component {
    #[Modelable]
    public bool $value = true;
    public ?string $label = null;
    public bool $required = true;
    public function render() {
        return view('core::livewire.fields.active-toggle');
    }
}
