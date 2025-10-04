<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ReminderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| كلها عليها prefix '/api'
| الرابط: http://127.0.0.1:8000/api/...
|
*/

// ✅ جملة اختبار للتأكد أن الـ API شغال
Route::get('/test', function () {
    return response()->json(['message' => 'API is working ✅']);
});

// ✅ ريمايندرز محمية بالـ auth (جلسة Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/reminders/upcoming', [ReminderController::class, 'upcomingReminders']);
    Route::post('/reminders/{id}/read', [ReminderController::class, 'markNotified']);
});
