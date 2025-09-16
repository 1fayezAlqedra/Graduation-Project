<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    function index()
    {
        return view('site.index');
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
