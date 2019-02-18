<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDashboard()
    {
        return view('admins.dashboard')->with('title', 'Admin Dashboard | ' . env('APP_NAME'));
    }

}
