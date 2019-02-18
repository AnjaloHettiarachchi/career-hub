<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function showIndex()
    {
        return view('site.index');
    }
}
