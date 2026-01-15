 <form wire:submit.prevent="save" class="space-y-6">
     <livewire:core.fields.localized-input field="name" :value="$name" :label="__('hr::positions.fields.name')" :error="$errors->first('name')" />
     <flux:select wire:model.defer="department_id" :label="__('hr::positions.fields.department')"
         error="department_id">
         <option value="">{{ __('hr::positions.placeholders.department') }}</option>
         @foreach ($this->departments as $department )
         <option value="{{ $department->id }}">
             {{ $department->name[app()->getLocale()] ?? '-' }}
         </option>
         @endforeach
     </flux:select>
     <flux:select wire:model.defer="grade_id" :label="__('hr::positions.fields.grade')"
         error="grade_id">
         <option value="">{{ __('hr::positions.placeholders.grade') }}</option>
         @foreach ($this->grades as $grade)
         <option value="{{ $grade->id }}">
             {{ $grade->name[app()->getLocale()] ?? '-' }}
         </option>
         @endforeach
     </flux:select>
     <livewire:core.fields.active-toggle wire:model.defer="is_active" :label="__('hr::positions.fields.is_active')" />
     <div class="flex justify-end">
         <flux:button type="submit" variant="primary">
             {{ __('hr::positions.actions.save') }}
         </flux:button>
     </div>

 </form>