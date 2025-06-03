<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\OrderController;

// Rutas públicas
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/api/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/api/register', [LoginController::class, 'register'])->name('login.register');
Route::post('/api/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas por Sanctum
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mensajes
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Partes
    Route::get('/api/parts', [PartController::class, 'index']);
    Route::get('/api/parts/{part}', [PartController::class, 'show']);

    // Categorías
    Route::get('/api/categories', [CategoryController::class, 'index']);
    Route::get('/api/categories/{category}', [CategoryController::class, 'show']);

    // Modelos
    Route::get('/api/models', [CarModelController::class, 'index']);
    Route::get('/api/models/{model}', [CarModelController::class, 'show']);
    Route::get('/api/models/brand/{brand}', [CarModelController::class, 'getByBrand']);

    // Órdenes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order:uuid}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order:uuid}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
});

Route::fallback(function () {
    return redirect()->route('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
