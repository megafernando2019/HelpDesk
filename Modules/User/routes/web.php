<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserController;

Route::middleware(['auto_login'])->group(function () {
    
    Route::get('/users/get_by_department', [UserController::class, 'getUsersDepartment']);
});
