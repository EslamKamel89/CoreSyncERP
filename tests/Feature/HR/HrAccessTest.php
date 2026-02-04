<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
it('prevents guests from accessing hr pages', function () {
    $routes = [
        'hr.departments.index',
        'hr.positions.index',
        'hr.grades.index',
        'hr.employees.index',
    ];
    foreach ($routes as $route) {
        $this->get(route($route))
            ->assertRedirectToRoute('login');
    }
});
it('prevents authenticated users without hr.manage_structure permission from accessing hr pages', function () {
    $user = PestHelper::normalUser();
    $routes = [
        'hr.departments.index',
        'hr.positions.index',
        'hr.grades.index',
        'hr.employees.index',
    ];
    foreach ($routes as $route) {
        $this->actingAs($user)
            ->get(route($route))
            ->assertForbidden();
    }
});
it('allows users with hr.manage_structure permission to access hr pages', function () {
    $user = PestHelper::hrManagerUser();
    $routes = [
        'hr.departments.index',
        'hr.positions.index',
        'hr.grades.index',
        'hr.employees.index',
    ];
    foreach ($routes as $route) {
        $this->actingAs($user)
            ->get(route($route))
            ->assertOk();
    }
});
