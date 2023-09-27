<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

// Rota de login
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::apiResource('company', CompanyController::class);

    Route::get('datetime', function() {
        return now();
    });

});

