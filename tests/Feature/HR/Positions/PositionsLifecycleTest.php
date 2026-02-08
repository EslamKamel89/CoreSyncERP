<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Positions\Index;
use Modules\HR\Livewire\Positions\Form;
use Modules\HR\Models\Position;

uses(RefreshDatabase::class);
it('allows updating an existing position', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department(['name' => ['en' => 'Engineering']]);
    $position = PestHelper::position($department, null, [
        'name' => ['en' => 'Developer'],
    ]);
    Livewire::actingAs($user)
        ->test(Form::class, ['position' => $position])
        ->set('name.en', 'Senior Developer')
        ->call('save')
        ->assertHasNoErrors();
    PestHelper::assertDatabaseHasLocalized(
        table: 'positions',
        column: 'name',
        locale: 'en',
        value: 'Senior Developer'
    );
});
it('allows deactivating a position', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department();
    $position = PestHelper::position($department, null, ['is_active' => true]);
    Livewire::actingAs($user)
        ->test(Form::class, ['position' => $position])
        ->set('is_active', false)
        ->call('save')
        ->assertHasNoErrors();
    $this->assertTrue(
        Position::where('id', $position->id)
            ->where('is_active', false)
            ->exists()
    );
});
it('filters positions by department', function () {
    $user = PestHelper::hrManagerUser();
    $engineering = PestHelper::department(['name' => ['en' => 'Engineering']]);
    $hr = PestHelper::department(['name' => ['en' => 'HR']]);
    PestHelper::position($engineering, null, ['name' => ['en' => 'Backend Engineer']]);
    PestHelper::position($hr, null, ['name' => ['en' => 'HR Manager']]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('filters.department_id', $engineering->id)
        ->assertSee('Backend Engineer')
        ->assertDontSee('HR Manager');
});
it('filters positions by active status', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department();
    PestHelper::position($department, null, ['name' => ['en' => 'Active Pos'], 'is_active' => true]);
    PestHelper::position($department, null, ['name' => ['en' => 'Inactive Pos'], 'is_active' => false]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('filters.status', 'active')
        ->assertSee('Active Pos')
        ->assertDontSee('Inactive Pos');
});

it('respects per-page selection on positions list', function () {
    $user = PestHelper::hrManagerUser();

    $department = PestHelper::department();

    foreach (range(1, 12) as $i) {
        PestHelper::position($department, null, [
            'name' => ['en' => "Position {$i}"],
        ]);
    }

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('perPage', 5)
        ->assertCount('positions.list.rows', 5);
});
