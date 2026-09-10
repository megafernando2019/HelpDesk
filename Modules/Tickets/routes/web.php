<?php

use Illuminate\Support\Facades\Route;
use Modules\Tickets\Http\Controllers\TicketsController;

Route::middleware(['auto_login'])->group(function () {
    //Ruta de prueba
    Route::get('/tickets/valid-test', [TicketsController::class, 'test']);
    
    Route::get('/tickets/get_current_details_create', [TicketsController::class, 'getDetailsCreateForm']);
    Route::get('/get_my_tickets', [TicketsController::class, 'getTicketsByUserStatus']);
    Route::post('/save_observation', [TicketsController::class, 'updateOrSaveObservations']);
    Route::post('/assing_ticket_user', [TicketsController::class, 'assingUserTicket']);    
    Route::post('/updated_status', [TicketsController::class, 'updateStatus']);
    Route::post('/get_ticket_logs_by_id', [TicketsController::class, 'getLogsByTicketId']); 
    //Asignar ticket
    Route::get('/assing_tickets', [TicketsController::class, 'viewAssingTickets'])
         ->name('tickets.assing');
    Route::get('/tickets/get_tickets_status_assgin', [TicketsController::class, 'getTicketsPendingAssing']); 
    // bulk assing tickets user
    Route::post('/tickets/assign_bulk', [TicketsController::class, 'assignBulkTickets']);
    Route::resource('tickets', TicketsController::class)->names('tickets');
});
