<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (Auth::guard('company')->attempt(['com_user_name' => $request['company_user_name'], 'password' => $request['password']], $request['remember'])) {

            $com_id = DB::table('companies')
                ->where('com_user_id', Auth::guard('company')->user()->getAuthIdentifier())
                ->pluck('com_id')
                ->first();

            if ($com_id) {
                return redirect()->route('companies.home', $com_id);
            } else {
                return redirect()->route('companies.showCreate');
            }

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
