@extends('layouts.main')

@section('nav')

        <a class="item" href="{{ route('companies.showRegister') }}">
            <h4><i class="user add icon"></i> REGISTER</h4>
        </a>
        <a class="item" href="{{ route('companies.showLogin') }}">
            <h4><i class="sign-in icon"></i> LOGIN</h4>
        </a>

@endsection

@section('content')
    <h1>Index</h1>
@endsection