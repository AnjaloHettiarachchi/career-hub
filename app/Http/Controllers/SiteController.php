<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function showIndex()
    {
        return view('site.index');
    }

    public function showCompanyIndex()
    {
        return view('site.company.index')->with('title', 'Company | ' . env('APP_NAME'));
    }

}
