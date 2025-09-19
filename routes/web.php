<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\home\TaskController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;

// Auth routes (Breeze / Jetstream / Fortify)
require __DIR__ . '/auth.php';

// Redirect dashboard → home.index
Route::get('/dashboard', fn() => redirect()->route('home.index'))
    ->middleware(['auth'])
    ->name('dashboard');

// Admin routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('users', AdminUserController::class);
    });

// Site routes (للمستخدم العادي)
Route::middleware('auth')->name('home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/tasks', [HomeController::class, 'tasks'])->name('tasks');
    Route::get('/calendar', [HomeController::class, 'calendar'])->name('calendar');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
});

// Task routes
Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
Route::patch('/tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete')->middleware('auth');

});
