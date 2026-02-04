<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Departments\Index;
use Modules\HR\Livewire\Departments\Form;
use Modules\HR\Models\Department;

uses(RefreshDatabase::class);
it('allows updating an existing department', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department([
        'name' => [
            'en' => 'Finance',
            'ar' => 'المالية',
        ],
    ]);
    Livewire::actingAs($user)
        ->test(Form::class, ['department' => $department])
        ->set('name.en',  'Finance Updated')
        ->call('save')
        ->assertHasNoErrors();
    PestHelper::assertDatabaseHasLocalized(
        table: 'departments',
        column: 'name',
        locale: 'en',
        value: 'Finance Updated'
    );
});
it('allows deactivating a department', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department(['is_active' => true]);
    Livewire::actingAs($user)
        ->test(Form::class, ['department' => $department])
        ->set('is_active', false)
        ->call('save')
        ->assertHasNoErrors();
    $this->assertTrue(
        Department::where('id', $department->id)
            ->where('is_active', false)->exists()
    );
});
it('filters departments by active status', function () {
    $user = PestHelper::hrManagerUser();
    PestHelper::department(['name' => ['en' => 'Active Dept'], 'is_active' => true]);
    PestHelper::department(['name' => ['en' => 'Inactive Dept'], 'is_active' => false]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('filters.status', 'active')
        ->assertSee('Active Dept')
        ->assertDontSee('Inactive Dept');
});
it('sorts departments by is_active', function () {
    $user = PestHelper::hrManagerUser();
    PestHelper::department(['name' => ['en' => 'Sales'], 'is_active' => false]);
    PestHelper::department(['name' => ['en' => 'Engineering'], 'is_active' => true]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('sortColumn', 'is_active')
        ->set('sortDirection', 'desc')
        ->assertSeeInOrder(['Engineering', 'Sales']);
});
it('respects per-page selection on departments list', function () {
    $user = PestHelper::hrManagerUser();

    foreach (range(1, 15) as $i) {
        PestHelper::department([
            'name' => ['en' => "Dept {$i}"],
        ]);
    }

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('perPage', 5)
        ->assertCount('departments.list.rows', 5);
});
