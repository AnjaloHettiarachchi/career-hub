@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/student.login.css') }}">
@endsection

@section('content')
    <div id="container" class="ui clearing segment">
        <h1>Student Login</h1>
        <p>Provide your Learning Management System (LMS) credentials for authentication.</p>

        <form action="{{ route('students.doLogin') }}" method="POST" class="ui form">

            <div class="field">
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" placeholder="Username">
                </div>
            </div>

            <div class="field">
                <div class="ui left icon input">
                    <i class="key icon"></i>
                    <input type="password" placeholder="Password">
                </div>
            </div>

            <button class="ui labeled icon primary right floated button">
                <i class="sign-in icon"></i> Login
            </button>

        </form>

    </div>
@endsection