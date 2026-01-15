 <form wire:submit.prevent="save" class="space-y-6">
     <livewire:core.fields.localized-input field="name" :value="$name" :label="__('hr::departments.fields.name')" :error="$errors->first('name')" />
     <livewire:core.fields.active-toggle wire:model.defer="is_active" :label="__('hr::departments.fields.is_active')" />
     <div class="flex justify-end">
         <flux:button type="submit" variant="primary">
             {{ __('hr::departments.actions.save') }}
         </flux:button>
     </div>

 </form>