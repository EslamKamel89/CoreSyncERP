<?php

use Illuminate\Support\Facades\Route;
use Modules\HR\Http\Controllers\HRController;
use Modules\HR\Livewire\Departments;
use Modules\HR\Livewire\Positions;
use Modules\HR\Livewire\Employees;
use Modules\HR\Livewire\Grades;
use Spatie\Permission\Middleware\PermissionMiddleware;

Route::middleware(['auth', PermissionMiddleware::using('hr.manage_structure')])
    ->prefix('hr')
    ->name('hr.')
    ->group(function () {
        Route::get('departments', Departments\Index::class)->name('departments.index');
        Route::get('departments/create', Departments\Create::class)->name('departments.create');
        Route::get('departments/{department}/edit', Departments\Edit::class)->name('departments.edit');
        Route::get('positions', Positions\Index::class)->name('positions.index');
        Route::get('positions/create', Positions\Create::class)->name('positions.create');
        Route::get('positions/{position}/edit', Positions\Edit::class)->name('positions.edit');
        Route::get('employees', Employees\Index::class)->name('employees.index');
        Route::get('employees/create', Employees\Create::class)->name('employees.create');
        Route::get('employees/{employee}/edit', Employees\Edit::class)->name('employees.edit');
        Route::get('grades', Grades\Index::class)->name('grades.index');
        Route::get('grades/create', Grades\Create::class)->name('grades.create');
        Route::get('grades/{grade}/edit', Grades\Edit::class)->name('grades.edit');
    });
