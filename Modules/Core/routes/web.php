<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;



Route::get('/core-test', function () {
    return response()->json(['message' => 'core module loaded']);
});
