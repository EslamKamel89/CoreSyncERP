<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            {{ __('hr::hr.departments.title') }}
        </h2>

        <flux:button
            href="{{ route('hr.departments.create') }}"
            wire:navigate
            variant="primary">
            {{ __('hr::hr.departments.create') }}
        </flux:button>
    </div>
    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('hr::hr.departments.search_placeholder') }}"
        clearable />
    {{-- Desktop table --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full border rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">
                        {{ __('hr::hr.departments.title') }}
                    </th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($this->departments as $department)
                <tr>
                    <td class="px-4 py-3 font-medium">
                        {{ $department->name[app()->getLocale()] ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        <flux:button
                            size="sm"
                            href="{{ route('hr.departments.edit', $department) }}"
                            wire:navigate>
                            <flux:icon.pencil class="size-4" />
                        </flux:button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500">
                        {{ __('hr::hr.departments.empty') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Mobile cards --}}
    <div class="space-y-3 md:hidden">
        @forelse ($this->departments as $department)
        <div
            x-data="{ open: false }"
            class="rounded-lg border">
            {{-- Card header --}}
            <button
                type="button"
                @click="open = !open"
                class="w-full flex items-center justify-between p-4">
                <span class="font-medium">
                    {{ $department->name[app()->getLocale()] ?? '-' }}
                </span>

                <svg
                    class="h-5 w-5 transition-transform"
                    :class="{ 'rotate-180': open }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Collapsible content --}}
            <div
                x-show="open"
                x-collapse
                class="border-t p-4">
                <div class="w-full flex justify-end">

                    <flux:button
                        size="sm"
                        href="{{ route('hr.departments.edit', $department) }}"
                        wire:navigate
                        class="w-fit">
                        <flux:icon.pencil class="size-4" />
                    </flux:button>
                </div>
            </div>
        </div>
        @empty
        <div class="text-sm text-gray-500">
            {{ __('hr::hr.departments.empty') }}
        </div>
        @endforelse
    </div>

    <div>
        {{ $this->departments->links() }}
    </div>
</div>