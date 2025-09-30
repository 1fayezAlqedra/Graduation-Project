<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $user = auth()->user();
        return view('site.settings', compact('user'));
    }

    /**
     * Update user settings.
     */
   public function update(Request $request, string $id)
{
    $user = auth()->user();

    // تحديث الاسم والبريد
    if ($request->has('name') || $request->has('email')) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);
        $user->update($request->only('name', 'email'));
    }

    // تحديث كلمة المرور
    if ($request->filled('new_password')) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();
    }

    // تحديث التذكيرات
    $user->reminders = $request->has('reminders') ? 1 : 0;
    $user->save();

    return redirect()->back()->with('success', 'Settings updated successfully.');
}


    /**
     * Delete the user account.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
