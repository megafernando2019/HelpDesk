<?php

use Illuminate\Support\Facades\Route;
use Modules\Tickets\Http\Controllers\TicketsController;

Route::middleware(['auto_login'])->group(function () {
    //Ruta de prueba
    Route::get('/tickets/valid-test', [TicketsController::class, 'test']);
    
    Route::get('/tickets/get_current_details_create', [TicketsController::class, 'getDetailsCreateForm']);
    Route::get('/get_my_tickets', [TicketsController::class, 'getTicketsByUserStatus']);
    Route::resource('tickets', TicketsController::class)->names('tickets');
});
