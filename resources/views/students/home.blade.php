@extends('layouts.main')

@section('nav')
    <a class="item" href="{{ route('students.showLogin') }}">
        <h4><i class="sign-in icon"></i>LOGIN</h4>
    </a>
@endsection

@section('content')
    <h1>Home</h1>
@endsection