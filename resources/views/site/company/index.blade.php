@extends('layouts.main')

@section('nav')
    @guest('admin')
        <a class="item" href="{{ route('companies.showLogin') }}">
            <h4><i class="sign-in icon"></i>LOGIN</h4>
        </a>
    @else
        <a class="item" style="background-color: #BD2828" href="{{ route('admins.logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <h4><i class="sign-out icon"></i>LOGOUT</h4>
        </a>
        <form id="logout-form" action="{{ route('admins.logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    @endguest
@endsection

@section('content')
    <h1>Index</h1>
@endsection