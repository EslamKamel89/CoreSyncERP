<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Positions\Index;
use Modules\HR\Livewire\Positions\Form;

uses(RefreshDatabase::class);
it('renders positions index page successfully', function () {
    $user = PestHelper::hrManagerUser();

    $this->actingAs($user)
        ->get(route('hr.positions.index'))
        ->assertOk();
});
it('allows creating a position with required department and optional grade', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department([
        'name' => ['en' => 'Engineering'],
    ]);
    $grade = PestHelper::grade([
        'name' => ['en' => 'Senior'],
    ]);
    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', ['en' => 'Backend Engineer'])
        ->set('department_id', $department->id)
        ->set('grade_id', $grade->id)
        ->set('is_active', true)
        ->call('save')
        ->assertHasNoErrors();
    PestHelper::assertDatabaseHasLocalized(
        table: 'positions',
        column: 'name',
        locale: 'en',
        value: 'Backend Engineer'
    );
});


it('allows creating a position without a grade', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department([
        'name' => ['en' => 'HR'],
    ]);
    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', ['en' => 'HR Specialist'])
        ->set('department_id', $department->id)
        ->set('grade_id', null)
        ->call('save')
        ->assertHasNoErrors();
});
