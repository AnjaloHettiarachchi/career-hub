<?php

namespace App\Http\Controllers;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    public function showHome()
    {
        return view('students.home')->with('title', '{Student} Home | ' . env('APP_NAME'));
    }

    public function showCreate()
    {
        return view('students.create')->with('title', 'Student › Create Account | ' . env('APP_NAME'));
    }
}
