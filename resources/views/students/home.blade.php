@extends('layouts.main')

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
    <h1>Home</h1>
@endsection