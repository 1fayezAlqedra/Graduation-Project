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
use App\Http\Controllers\API\ReminderController; // ✅ For reminders

// Auth routes (Breeze / Jetstream / Fortify)
require __DIR__ . '/auth.php';

// Redirect dashboard → home.index
Route::get('/dashboard', fn() => redirect()->route('home.index'))
    ->middleware(['auth'])
    ->name('dashboard');

// ================= ADMIN ROUTES =================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('users', AdminUserController::class);
    });

// ================= USER ROUTES =================
Route::middleware('auth')->name('home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/tasks', [HomeController::class, 'tasks'])->name('tasks');
    Route::get('/calendar', [HomeController::class, 'calendar'])->name('calendar');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
    Route::get('/aboutUs', [HomeController::class, 'aboutUs'])->name('aboutUs');

});

// ================= TASK ROUTES =================
Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{id}/complete', [TaskController::class, 'complete'])
        ->name('tasks.complete')
        ->middleware('auth');
});

// ================= CALENDAR ROUTES =================
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::post('/calendar/fetch', [CalendarController::class, 'fetchMonth'])->name('calendar.fetch');

// ================= PROFILE ROUTES =================
Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Home\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit', [\App\Http\Controllers\Home\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/', [\App\Http\Controllers\Home\ProfileController::class, 'update'])->name('profile.update');
});

// ================= SETTINGS ROUTES =================
Route::middleware(['auth'])->group(function () {
    Route::resource('settings', SettingsController::class)
        ->only(['index', 'update', 'destroy']);
});

// ================= REMINDER ROUTES =================
// Here we handle reminders (auth required, using Breeze auth session)
Route::middleware(['auth'])->prefix('reminders')->name('reminders.')->group(function () {
    Route::get('/upcoming', [ReminderController::class, 'upcomingReminders'])->name('upcoming');
    Route::post('/{id}/read', [ReminderController::class, 'markNotified'])->name('read');


});
















