<?php

namespace App\Http\Controllers\auth;

use App\CompanyUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CompanyRegisterController extends Controller
{
    public function showCompanyRegister() {

        return view('companies.register')->with('title', 'Company › Register | ' . env('APP_NAME'));

    }

    public function doCompanyRegister(Request $request)
    {
        //Validation
        $this->validate($request, [
            'com_name' => 'required',
            'password' => 'required|confirmed'
        ], [], [
            'com_name' => 'Company Username',
            'password' => 'Company Password'
        ]);

        $com_user = new CompanyUser();
        $com_user->com_user_name = $request['com_name'];
        $com_user->com_user_password = bcrypt($request['password']);
        $com_user->save();

        return redirect()->route('companies.showLogin');

    }

}
