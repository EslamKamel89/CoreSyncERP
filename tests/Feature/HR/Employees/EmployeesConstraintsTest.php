<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Employees\Form;
use Modules\HR\Models\Employee;

uses(RefreshDatabase::class);
it('requires department and position when creating an employee', function () {
    $user = PestHelper::hrManagerUser();
    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', 'Jane Doe')
        ->call('save')
        ->assertHasErrors([
            'department_id',
            'position_id',
        ]);
});

it('allows creating an employee with optional grade', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department();
    $grade      = PestHelper::grade(['name' => ['en' => 'Senior']]);
    $position   = PestHelper::position($department, $grade);
    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', 'Jane Doe')
        ->set('display_name', ['en' => 'Jane Doe'])
        ->set('department_id', $department->id)
        ->set('position_id', $position->id)
        ->set('grade_id', $grade->id)
        ->set('hire_date', now()->subMonth()->toDateString())
        ->call('save')
        ->assertHasNoErrors();
});
it('allows creating an employee without base salary override', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();
    $position   = PestHelper::position($department);

    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', 'No Salary Employee')
        ->set('display_name', ['en' => 'No Salary Employee'])
        ->set('department_id', $department->id)
        ->set('position_id', $position->id)
        ->set('hire_date', now()->subMonth()->toDateString())
        ->call('save')
        ->assertHasNoErrors();

    $this->assertTrue(
        Employee::whereNull('base_salary')->exists()
    );
});
