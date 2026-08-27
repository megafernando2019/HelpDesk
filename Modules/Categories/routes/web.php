<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\CategoriesController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/categories/by_department', [CategoriesController::class, 'getCategoriesByDepartment']);

    Route::resource('categories', CategoriesController::class)->names('categories');
});
