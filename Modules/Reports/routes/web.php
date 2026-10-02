<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('reports')->group(function () {
        //Para categoria en modulo reportes y sus detalles
        Route::get('/get_summary', [ReportsController::class, 'getDataSummaryByModule']); 

        //Prefijo para rutas del submodulo de servicios
        Route::prefix('services')->group(function () {
            Route::get('/', [ReportsController::class, 'viewReportService'])
                 ->name('reports.index.service'); 
        });

        //Prefijo para rutas del submodulo de usuarios encargados
        Route::prefix('users_assings')->group(function() {
           Route::get('/', [ReportsController::class, 'viewReportUserAssing'])
                 ->name('reports.index.users_assings');
        });
    });
    
    //Para submodulo de categorias
    Route::resource('reports', ReportsController::class)->names('reports');
});
