<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/entries', [DashboardController::class, 'entries'])->name('dashboard.entries');
    Route::post('/dashboard/entries', [DashboardController::class, 'store'])->name('dashboard.entries.store');
    Route::delete('/dashboard/entries/{date}', [DashboardController::class, 'destroy'])->name('dashboard.entries.destroy');
});

