<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function username()
    {
        return 'admin_name';
    }

    public function showAdminLogin()
    {
        return view('admins.login')->with('title', 'Admin › Login | ' . env('APP_NAME'));
    }

    public function doAdminLogin(Request $request)
    {
        //Validation
        $this->validate($request, [
            'admin_name' => 'required',
            'password' => 'required|min:8'
        ], [], [
            'admin_name' => 'Username',
            'password' => 'Password'
        ]);

        //Attempt Login
        if (Auth::guard('admin')->attempt(['admin_name' => $request['admin_name'], 'password' => $request['password']], $request['remember'])) {
            return redirect()->intended(route('admins.dashboard'));
        } else {
            return redirect()->back()
                ->with('error', 'These credentials do not match our records.')
                ->withInput();
        }

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('site.index');
    }

}
