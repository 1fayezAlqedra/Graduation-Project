<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\home\TaskController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\home\CalendarController;
use App\Http\Controllers\Home\SettingsController;
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


// calendre routs
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::post('/calendar/fetch', [CalendarController::class, 'fetchMonth'])->name('calendar.fetch');
// Profile Routes
Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Home\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit', [\App\Http\Controllers\Home\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/', [\App\Http\Controllers\Home\ProfileController::class, 'update'])->name('profile.update');
});

// Settings Route

Route::middleware(['auth'])->group(function () {
    // Resource فقط للـ index, update, destroy
    Route::resource('settings', SettingsController::class)
        ->only(['index', 'update', 'destroy']);
});
