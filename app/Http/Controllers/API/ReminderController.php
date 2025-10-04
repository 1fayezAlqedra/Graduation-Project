<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Get upcoming reminders for the logged-in user.
     * Only reminders within the next 10 minutes that are not notified.
     */
    public function upcomingReminders(Request $request)
    {
        $user = Auth::user();
        $now = now();

        $reminders = Reminder::with('task') // include related task info
            ->where('user_id', $user->id)
            ->where('remind_at', '<=', $now->addMinutes(10)) // any reminder within 10 minutes
            ->where('notified', false)
            ->orderBy('remind_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'reminders' => $reminders
        ]);
    }
    // Mark a reminder as notified (so it won't show again).
    public function markNotified(Request $request, $id)
    {
        $reminder = Reminder::where('user_id', Auth::id())->findOrFail($id);

        $reminder->update(['notified' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Reminder marked as notified'
        ]);
    }
}
