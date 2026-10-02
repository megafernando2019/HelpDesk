<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserController;

Route::middleware(['auto_login'])->group(function () {
    
    //Obtiene usuarios por su departamento id
    Route::get('/users/get_by_department', [UserController::class, 'getUsersDepartment']);

     //Obtiene usuarios por su team id
    Route::get('/users/get_by_team', [UserController::class, 'getUsersByTeam']);

    Route::get('/users/get_current_members', [UserController::class, 'getMembers']);

    Route::get('/users/get_current_roles', [UserController::class, 'getRoles']);

    Route::post('/users/update_session_rol', [UserController::class, 'changeRol']);

});

