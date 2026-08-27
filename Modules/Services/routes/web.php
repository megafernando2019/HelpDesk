<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Http\Controllers\ServicesController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/services/by_category', [ServicesController::class, 'getServicesByCategory']);

    Route::resource('services', ServicesController::class)->names('services');
});
