<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [LoginController::class, 'show'])->name('login');
Route::post('/api/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/api/logout', [LoginController::class, 'logout'])->name('logout');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
