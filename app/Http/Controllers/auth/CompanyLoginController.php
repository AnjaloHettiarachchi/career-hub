<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:company')->except('logout');
    }

    public function showCompanyLogin()
    {
        return view('companies.login')->with('title', 'Company › Login | ' . env('APP_NAME'));
    }

    public function doCompanyLogin(Request $request)
    {

        //Validation
        $this->validate($request, [
            'company_user_name' => 'required',
            'password' => 'required|min:8',
        ], [], [
            'company_user_name' => 'Username',
            'password' => 'Password',
        ]);

        //Attempt Login
        if (Auth::guard('company')->attempt(['company_user_name' => $request['company_user_name'], 'password' => $request['password']], $request['remember'])) {
            return redirect()->intended(route('companies.home'));
        } else {
            return redirect()->back()
                ->with('error', 'These credentials do not match our records.')
                ->withInput();
        }

    }

    public function logout()
    {
        Auth::guard('company')->logout();
        return redirect()->route('site.index');
    }

}
