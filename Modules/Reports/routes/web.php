<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('reports')->group(function () {
        Route::get('/get_summary', [ReportsController::class, 'getDataSummaryByModule']); 
    });
    
    Route::resource('reports', ReportsController::class)->names('reports');
});
