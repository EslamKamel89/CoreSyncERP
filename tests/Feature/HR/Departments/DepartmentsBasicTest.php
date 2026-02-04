<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Departments\Index;
use Modules\HR\Livewire\Departments\Form;
use Modules\HR\Models\Department;

uses(RefreshDatabase::class);
it('renders departments index page successfully', function () {
    $user = PestHelper::hrManagerUser();
    $this->actingAs($user)
        ->get(route('hr.departments.index'))
        ->assertOk();
});
it('allows creating a department with localized name', function () {
    $user = PestHelper::hrManagerUser();
    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', [
            'en' => 'Engineering',
            'ar' => 'الهندسة',
        ])->set('is_active', true)
        ->call('save')
        ->assertHasNoErrors();
    PestHelper::assertDatabaseHasLocalized(
        table: 'departments',
        column: 'name',
        locale: 'en',
        value: 'Engineering'
    );
    PestHelper::assertDatabaseHasLocalized(
        table: 'departments',
        column: 'name',
        locale: 'ar',
        value: 'الهندسة'
    );
});
it('shows english localized department name in departments list', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department([
        'name' => [
            'en' => 'Finance',
            'ar' => 'المالية',
        ],
    ]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->assertSee('Finance');
});
it('shows arabic localized department name in departments list', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department([
        'name' => [
            'en' => 'Finance',
            'ar' => 'المالية',
        ],
    ]);
    app()->setLocale('ar');
    Livewire::actingAs($user)
        ->test(Index::class)
        ->assertSee('المالية');
});
