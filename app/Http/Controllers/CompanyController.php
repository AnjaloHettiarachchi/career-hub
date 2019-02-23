<?php

namespace App\Http\Controllers;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:company');
    }

    public function showHome()
    {
        return view('companies.home')->with('title', 'Company Home | ' . env('APP_NAME'));
    }

}
