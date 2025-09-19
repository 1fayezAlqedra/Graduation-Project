<?php

namespace App\Http\Controllers\home;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{


function index()
{
    $today = Carbon::today(); 
    $tasks = Task::where('user_id', Auth::id())
                ->whereDate('start_time', $today) // أو whereDate('end_time', $today)
                ->get();

    return view('site.index', compact('tasks', 'today'));
}


    function tasks()
    {
        return view('site.tasks');
    }
    function calendar()
    {
        return view('site.calendar');
    }

    function profile()
    {
        return view('site.profile');

    }

    function settings()
    {
        return view('site.settings');
    }
}
