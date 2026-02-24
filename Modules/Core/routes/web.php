<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Core\Livewire\Settings\CompanyProfile;
use Modules\Core\Livewire\Roles;

Route::middleware(['auth'])->group(function () {
    Route::get(
        '/',
        fn() => response()->redirectToRoute('dashboard')
    )->name('home');
    Route::view('/dashboard', 'core::dashboard')->name('dashboard');
    Route::prefix('/settings')->name('core.settings.')->group(function () {
        Route::get('/company', CompanyProfile::class)->name('company');
    });
    Route::prefix('admin')
        ->name('core.')
        ->group(function () {
            Route::get('/roles', Roles\Index::class)
                ->name('roles.index');

            Route::get('/roles/create', Roles\Create::class)
                ->name('roles.create');

            Route::get('/roles/{role}/edit', Roles\Edit::class)
                ->name('roles.edit');
        });
});
