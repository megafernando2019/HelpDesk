<?php

use Illuminate\Support\Facades\Route;
use Modules\RecurringIncidents\Http\Controllers\RecurringIncidentsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {

    //Route::apiResource('recurringincidents', RecurringIncidentsController::class)->names('recurringincidents');
});
