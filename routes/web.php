<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route to dashboard if verified otherwise to login
Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect('/login');
});

// Prevent users from routing to dashboard if not verified
Route::get('/dashboard', function () {
    return response()
    ->view('dashboard')
    ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
