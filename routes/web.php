<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/api/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/api/register', [LoginController::class, 'register'])->name('login.register');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    return redirect()->route('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
