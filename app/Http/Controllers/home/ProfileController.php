<?php

namespace App\Http\Controllers\Home;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * عرض صفحة البروفايل (معلومات المستخدم).
     */
    public function show()
    {
        $user = Auth::user();

        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->completed()->count();
        $pendingTasks = $user->tasks()->incomplete()->count();

        return view('site.profile', compact(
            'user',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
        ));
    }


    /**
     * عرض فورم تعديل البروفايل.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('site.edit-profile', compact('user'));
    }

    /**
     *Update User Profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password is incorrect.'
                ]);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }


}
