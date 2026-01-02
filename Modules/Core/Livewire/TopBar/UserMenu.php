<?php

namespace Modules\Core\Livewire\TopBar;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserMenu extends Component {
    public ?string $locale = null;
    public array $availableLocales =  [];
    public function mount() {
        $this->locale = Auth::user()->locale;
        $this->availableLocales =  config('core.locales.availableLocales');
    }
    public function updatedLocale(string $value) {
        $user = Auth::user();
        if ($value === $user->locale) {
            return;
        }
        if (!array_key_exists($value, $this->availableLocales)) {
            return;
        }
        $user->update(['locale' => $value]);
        $url =  redirect()->back()->getTargetUrl();
        $this->redirect($url, true);
    }

    public function render() {
        return view('core::livewire.top-bar.user-menu');
    }
}
