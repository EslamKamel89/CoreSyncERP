<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;



Route::view('/dashboard', 'core::dashboard')->name('dashboard');
