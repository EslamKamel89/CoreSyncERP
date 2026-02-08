<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Employees\Index;
use Modules\HR\Livewire\Employees\Form;

uses(RefreshDatabase::class);
it('renders employees index page successfully', function () {
    $user = PestHelper::hrManagerUser();

    $this->actingAs($user)
        ->get(route('hr.employees.index'))
        ->assertOk();
});
it('allows creating an employee with required relations', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department(['name' => ['en' => 'Engineering']]);
    $position   = PestHelper::position($department, null, ['name' => ['en' => 'Backend Dev']]);

    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', 'John Doe')
        ->set('display_name', ['en' => 'John Doe'])
        ->set('department_id', $department->id)
        ->set('position_id', $position->id)
        ->set('hire_date', now()->subMonth()->toDateString())
        ->set('is_active', true)
        ->call('save')
        ->assertHasNoErrors();
});
