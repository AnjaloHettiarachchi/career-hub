@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/student.login.css') }}">
@endsection

@section('content')
    <div id="container" class="ui clearing centered raised card">
        <div class="image">
            <img src="{{ asset('png/stu_banner.jpg') }}" alt="Students">
        </div>
        <div class="content">
            <h1 class="header">Student<i class="angle right icon"></i>Sign in</h1>
            <p class="meta">Provide your Learning Management System (LMS) credentials to sign in to the system.</p>

            @include('includes.messages')

            <form action="{{ route('students.doLogin') }}" method="POST" class="ui form">

                {{ csrf_field() }}

                <div class="field {{ $errors->has('stu_user_name') ? 'error' : '' }}">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" placeholder="Username" name="stu_user_name" id="stu_user_name"
                               value="{{ old('stu_user_name') }}">
                    </div>
                </div>

                <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                    <div class="ui left icon input">
                        <i class="key icon"></i>
                        <input type="password" placeholder="Password" name="password" id="password">
                    </div>
                </div>

                <button class="ui labeled icon primary right floated button">
                    <i class="sign-in icon"></i> Sign in
                </button>

            </form>
        </div>

    </div>
@endsection