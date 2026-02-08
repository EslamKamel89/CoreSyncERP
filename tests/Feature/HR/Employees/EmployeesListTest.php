<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Employees\Index;

uses(RefreshDatabase::class);

it('filters employees by department', function () {
    $user = PestHelper::hrManagerUser();

    $engineering = PestHelper::department(['name' => ['en' => 'Engineering']]);
    $hr          = PestHelper::department(['name' => ['en' => 'HR']]);

    $engPosition = PestHelper::position($engineering);
    $hrPosition  = PestHelper::position($hr);

    PestHelper::employee($engineering, $engPosition, null, ['name' => 'Alice']);
    PestHelper::employee($hr, $hrPosition, null, ['name' => 'Bob']);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('filters.department_id', $engineering->id)
        ->assertSee('Alice')
        ->assertDontSee('Bob');
});

it('filters employees by position', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();

    $backend = PestHelper::position($department, null, ['name' => ['en' => 'Backend']]);
    $frontend = PestHelper::position($department, null, ['name' => ['en' => 'Frontend']]);

    PestHelper::employee($department, $backend, null, ['name' => 'Alice']);
    PestHelper::employee($department, $frontend, null, ['name' => 'Bob']);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('filters.position_id', $backend->id)
        ->assertSee('Alice')
        ->assertDontSee('Bob');
});

it('filters employees by active status', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();
    $position   = PestHelper::position($department);

    PestHelper::employee($department, $position, null, [
        'name' => 'Active Employee',
        'is_active' => true,
    ]);

    PestHelper::employee($department, $position, null, [
        'name' => 'Inactive Employee',
        'is_active' => false,
    ]);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('filters.status', 'active')
        ->assertSee('Active Employee')
        ->assertDontSee('Inactive Employee');
});

it('searches employees by name or employee number', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();
    $position   = PestHelper::position($department);

    $employee = PestHelper::employee($department, $position, null, [
        'name' => 'Search Target',
    ]);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('search', 'Search')
        ->assertSee('Search Target');
});

it('sorts employees by name', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();
    $position   = PestHelper::position($department);

    PestHelper::employee($department, $position, null, ['name' => 'Charlie']);
    PestHelper::employee($department, $position, null, ['name' => 'Alice']);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('sortColumn', 'name')
        ->set('sortDirection', 'asc')
        ->assertSeeInOrder(['Alice', 'Charlie']);
});

it('respects per-page selection on employees list', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();
    $position   = PestHelper::position($department);

    foreach (range(1, 12) as $i) {
        PestHelper::employee($department, $position, null, [
            'name' => "Employee {$i}",
        ]);
    }

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('perPage', 5)
        ->assertCount('employees.list.rows', 5);
});
