<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Core\Livewire\Settings\CompanyProfile;

Route::middleware(['auth'])->group(function () {
    Route::get(
        '/',
        fn() => response()->redirectToRoute('dashboard')
    )->name('home');
    Route::view('/dashboard', 'core::dashboard')->name('dashboard');
    Route::prefix('/settings')->name('core.settings.')->group(function () {
        Route::get('/company', CompanyProfile::class)->name('company');
    });
});
