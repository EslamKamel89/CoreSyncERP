 <div class="flex items-center gap-3">
     <x-flux::badge>
         Admin
     </x-flux::badge>

     <x-flux::avatar
         name="{{ auth()->user()?->name }}"
         size="sm" />
 </div>