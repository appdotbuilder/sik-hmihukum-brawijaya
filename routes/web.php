<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\KaryaKaderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Library routes
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/', [LibraryController::class, 'index'])->name('index');
    });
    
    // Book routes
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/books/{book}', [BookController::class, 'store'])->name('books.store');
    
    // Karya Kader routes
    Route::get('/karya-kaders/{karyaKader}', [KaryaKaderController::class, 'show'])->name('karya-kaders.show');
    Route::post('/karya-kaders/{karyaKader}', [KaryaKaderController::class, 'store'])->name('karya-kaders.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';