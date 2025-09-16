<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    function index()
    {
        $users = User::all();
        $user = Auth::user(); // return the redisterd Admin

        return view('admin.index', compact('users', 'user'));
    }

    function Add_User()
    {
        return view('admin.addUser');
    }

}
