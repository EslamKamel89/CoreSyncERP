 <div>
     <flux:dropdown>
         <button>
             <x-flux::badge class="cursor-pointer">
                 <div class="flex space-x-3 items-center justify-center">
                     <x-flux::avatar
                         name="{{ auth()->user()?->name }}"
                         size="sm" />
                     <div>
                         {{ auth()->user()->roles[0]->name }}
                     </div>
                 </div>
             </x-flux::badge>
         </button>
         <flux:menu.separator />
         <flux:menu width="56">
             <flux:menu.submenu :heading="__('core::shared.language')" icon="language">
                 <flux:menu.radio.group wire:model.live="locale">
                     @foreach ($availableLocales as $key=>$value )
                     <flux:menu.radio :value="$key">{{ $value }}</flux:menu.radio>
                     @endforeach
                 </flux:menu.radio.group>
             </flux:menu.submenu>
         </flux:menu>
     </flux:dropdown>
 </div>