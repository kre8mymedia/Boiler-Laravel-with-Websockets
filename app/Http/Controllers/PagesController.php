<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function calendar()
    {
        return view('pages.calendar');
    }
}
