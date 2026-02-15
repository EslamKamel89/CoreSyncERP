<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Models\Department;
use Modules\HR\Models\Position;
use Modules\HR\Models\Employee;
use Modules\HR\Livewire\Departments\Index as DepartmentIndex;
use Modules\HR\Livewire\Positions\Index as PositionIndex;
use Modules\HR\Livewire\Employees\Index as EmployeeIndex;
use Modules\HR\Livewire\Positions\Form as PositionForm;
use Modules\HR\Livewire\Employees\Form as EmployeeForm;

uses(RefreshDatabase::class);

it('test_department_search_scope_works', function () {
    $user = PestHelper::hrManagerUser();
    PestHelper::department(['name' => ['en' => 'Finance']]);
    PestHelper::department(['name' => ['en' => 'Engineering']]);
    Livewire::actingAs($user)
        ->test(DepartmentIndex::class)
        ->set('search', 'Fin')
        ->assertSee('Finance')
        ->assertDontSee('Engineering');
});
it('test_position_filter_scopes_work_together', function () {
    $user = PestHelper::hrManagerUser();
    $engineering = PestHelper::department(['name' => ['en' => 'Engineering']]);
    $hr = PestHelper::department(['name' => ['en' => 'HR']]);

    PestHelper::position($engineering, null, [
        'name' => ['en' => 'Backend'],
        'is_active' => true,
    ]);
    PestHelper::position($engineering, null, [
        'name' => ['en' => 'Inactive Backend'],
        'is_active' => false,
    ]);
    PestHelper::position($hr, null, [
        'name' => ['en' => 'HR Manager'],
        'is_active' => true,
    ]);
    Livewire::actingAs($user)
        ->test(PositionIndex::class)
        ->set('filters.department_id', $engineering->id)
        ->set('filters.status', 'active')
        ->assertSee('Backend')
        ->assertDontSee('Inactive Backend')
        ->assertDontSee('HR Manager');
});
it('test_employee_index_query_applies_all_filters', function () {
    $user = PestHelper::hrManagerUser();
    $engineering = PestHelper::department(['name' => ['en' => 'Engineering']]);
    $hr = PestHelper::department(['name' => ['en' => 'HR']]);
    $backend = PestHelper::position($engineering);
    $hrPos   = PestHelper::position($hr);
    PestHelper::employee($engineering, $backend, null, [
        'name' => 'Target Employee',
        'is_active' => true,
    ]);
    PestHelper::employee($engineering, $backend, null, [
        'name' => 'Inactive Target',
        'is_active' => false,
    ]);
    PestHelper::employee($hr, $hrPos, null, [
        'name' => 'Other Employee',
        'is_active' => true,
    ]);
    Livewire::actingAs($user)
        ->test(EmployeeIndex::class)
        ->set('filters.department_id', $engineering->id)
        ->set('filters.position_id', $backend->id)
        ->set('filters.status', 'active')
        ->set('search', 'Target')
        ->assertSee('Target Employee')
        ->assertDontSee('Inactive Target')
        ->assertDontSee('Other Employee');
});
it('test_to_list_data_returns_expected_structure', function () {
    $department = PestHelper::department(['name' => ['en' => 'Engineering']]);
    $paginator = Department::query()->paginate(5);
    $data = Department::toListData($paginator);
    expect($data)->toHaveKey('rows');
    expect($data)->toHaveKey('headers');
    expect($data)->toHaveKey('emptyLabel');
});
it('test_deactivated_positions_are_not_selectable_for_new_employees', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department();
    PestHelper::position($department, null, [
        'name' => ['en' => 'Inactive Position'],
        'is_active' => false,
    ]);
    Livewire::actingAs($user)
        ->test(EmployeeForm::class)
        ->assertDontSee('Inactive Position');
});
it('test_status_scope_does_not_override_search_scope', function () {
    $user = PestHelper::hrManagerUser();
    $department = PestHelper::department();
    $position   = PestHelper::position($department);
    PestHelper::employee($department, $position, null, [
        'name' => 'Active Search',
        'is_active' => true,
    ]);
    PestHelper::employee($department, $position, null, [
        'name' => 'Inactive Search',
        'is_active' => false,
    ]);
    Livewire::actingAs($user)
        ->test(EmployeeIndex::class)
        ->set('search', 'Search')
        ->set('filters.status', 'active')
        ->assertSee('Active Search')
        ->assertDontSee('Inactive Search');
});
