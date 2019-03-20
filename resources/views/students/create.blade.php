@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/student.create.css') }}">
@endsection

@section('nav')

    <a class="item" style="background-color: #BD2828" href="{{ route('students.logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <h4><i class="sign-out icon"></i>LOGOUT</h4>
    </a>
    <form id="logout-form" action="{{ route('students.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

@endsection

@section('content')
    <div id="container" class="ui clearing raised segment">
        <h1><i class="fas fa-graduation-cap icon"></i> Student<i class="angle right icon"></i>Create Account</h1>
        <p>Provide necessary information and complete your student account.</p>

        @include('includes.messages')

        <form action="{{ route('students.doCreate') }}" method="POST" class="ui form" enctype="multipart/form-data">

            <div class="ui grid">
                <div class="ui two wide column">
                    <img id="avatar-preview" class="ui tiny fluid circular image"
                         src="{{ asset('png/stu_avatar.png') }}"
                         alt="avatar">
                </div>
                <div class="ui six wide column">
                    <div class="field {{ $errors->has('avatar') ? 'error' : '' }}">
                        <label for="avatar">Select an avatar for your account (Optional)</label>
                        <input type="file" name="avatar" id="avatar" accept="[image/jpeg][image/png]"
                               value="{{ old('avatar') }}">
                    </div>
                </div>
            </div>
            <br>

        </form>

    </div>
@endsection