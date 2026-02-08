<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Employees\Form;
use Modules\HR\Models\Employee;

uses(RefreshDatabase::class);


it('allows updating an existing employee', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();
    $position   = PestHelper::position($department);
    $employee   = PestHelper::employee($department, $position);
    Livewire::actingAs($user)
        ->test(Form::class, ['employee' => $employee])
        ->set('name', 'Updated Name')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertTrue(
        Employee::where('id', $employee->id)
            ->where('name', 'Updated Name')
            ->exists()
    );
});

it('allows deactivating an employee', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();
    $position   = PestHelper::position($department);
    $employee   = PestHelper::employee($department, $position, null, ['is_active' => true]);

    Livewire::actingAs($user)
        ->test(Form::class, ['employee' => $employee])
        ->set('is_active', false)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertTrue(
        Employee::where('id', $employee->id)
            ->where('is_active', false)
            ->exists()
    );
});
