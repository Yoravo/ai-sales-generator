<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesPageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rate limit for generate, max 10 requests per minute
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('sales-pages', [SalesPageController::class, 'store'])->name('sales-pages.store');
        Route::post('sales-pages/{salesPage}/regenerate', [SalesPageController::class, 'regenerate'])->name('sales-pages.regenerate');
    });

    Route::get('sales-pages/{salesPage}/export', [SalesPageController::class, 'export'])->name('sales-pages.export');
    Route::get('sales-pages/{salesPage}/preview', [SalesPageController::class, 'preview'])->name('sales-pages.preview');

    Route::resource('sales-pages', SalesPageController::class)->only(['create', 'index', 'show', 'destroy']);
});

require __DIR__ . '/auth.php';