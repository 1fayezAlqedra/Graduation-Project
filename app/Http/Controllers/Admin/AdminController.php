<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index()
    {
        $users = User::all();
        $authUser = Auth::user();

        // إحصائيات المستخدمين
        $totalUsers = User::count();

        // إحصائيات المهام
        $totalTasks = Task::count();
        $completedTasks = Task::where('completed', true)->count();
        $pendingTasks = Task::where('completed', false)->count();

        // إلغاء أو تأخير المهام (اعتمدت end_time بدل due_date لأنك غيرت التسمية)
        $canceledTasks = Task::where('completed', false)
            ->where('end_time', '<', now())
            ->count();

        return view('admin.index', compact(
            'users',
            'authUser',
            'totalUsers',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'canceledTasks'
        ));
    }


    function Add_User()
    {
        return view('admin.addUser');
    }

}
