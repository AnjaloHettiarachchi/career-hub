@extends('layouts.main')

@section('nav')
    @guest('admin')

        <a class="item" href="{{ route('students.showLogin') }}">
            <h4><i class="sign-in icon"></i> LOGIN</h4>
        </a>

    @else

        <a class="item" style="background-color: #BD2828" href="{{ route('admins.logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <h4><i class="sign-out icon"></i> LOGOUT</h4>
        </a>
        <form id="logout-form" action="{{ route('admins.logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    @endguest
@endsection

@section('css')
    <style type="text/css">
        .Site-content {
            background-image: url("{{ asset('svg/stu_index_bg.svg') }}");
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
@endsection