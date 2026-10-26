<?php

use Illuminate\Support\Facades\Route;
use Modules\RecurringIncidents\Http\Controllers\RecurringIncidentsController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('incidents')->group(function() {
          Route::get('/', [RecurringIncidentsController::class, 'index'])->name('incidents.index');

          Route::get('/data_incidents/', [RecurringIncidentsController::class, 'getDataKpMetrics']);

          Route::get('/tickets_detalle', [RecurringIncidentsController::class, 'getTicketsByGroup']);
    });
    // mmm no sera necesario
    //Route::resource('recurringincidents', RecurringIncidentsController::class)->names('recurringincidents');
});
