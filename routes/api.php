<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

// Rota de login
Route::post('login', [AuthController::class, 'login'])->name('login');

// Rotas protegidas pelo middleware auth.jwt (requer autenticação)
Route::middleware(['auth.jwt'])->group(function () {
    // Rota de logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Rotas de CRUD para a entidade 'company'
    Route::apiResource('company', CompanyController::class);
});

