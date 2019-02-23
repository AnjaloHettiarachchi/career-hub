@extends('layouts.main')

@section('nav')
    @guest
        {{--<a class="item" href="{{ route('students.showLogin') }}">--}}
        {{--<h4><i class="sign-in icon"></i>LOGIN</h4>--}}
        {{--</a>--}}
    @else

        <a class="item" style="background-color: #BD2828" href="{{ route('companies.logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <h4><i class="sign-out icon"></i>LOGOUT</h4>
        </a>
        <form id="logout-form" action="{{ route('companies.logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    @endguest
@endsection

@section('content')
    <h1>Company Home</h1>
@endsection