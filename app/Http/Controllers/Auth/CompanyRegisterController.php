<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;

class CompanyRegisterController extends Controller
{
    public function showCompanyRegister() {

        return view('companies.register')->with('title', 'Company › Register | ' . env('APP_NAME'));

    }
}
