<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    public function showAdminRegister()
    {
        return view('admins.register')->with('title', 'Admin › Register | ' . env('APP_NAME'));
    }

    public function doAdminRegister(Request $request)
    {
        //Validation
        try {
            $this->validate($request, [
                'admin_name' => 'required|regex:^[a-zA-Z0-9_]*$^|min:4',
                'password' => 'required|min:8|confirmed'
            ], [], [
                'admin_name' => 'Username',
                'password' => 'Password'
            ]);
        } catch (ValidationException $e) {
        }

        //Store
        try {
            $admin = new Admin;
            $admin->admin_name = $request['admin_name'];
            $admin->admin_password = Hash::make($request['password']);
            $admin->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'A new admin account has been successfully created.');

    }

}
