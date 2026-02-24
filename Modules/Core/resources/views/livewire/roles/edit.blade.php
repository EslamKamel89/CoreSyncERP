<div class="max-w-3xl space-y-8">
    <h1>{{ __('core::roles.edit.title') }}</h1>
    <p>{{ __('core::roles.edit.description') }}</p>

    <livewire:core.roles.form :role="$role" />
</div>