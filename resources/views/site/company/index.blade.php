@extends('layouts.main')

@section('nav')

        <a class="item" href="{{ route('companies.showRegister') }}">
            <h4><i class="user add icon"></i> REGISTER</h4>
        </a>
        <a class="item" href="{{ route('companies.showLogin') }}">
            <h4><i class="sign-in icon"></i> LOGIN</h4>
        </a>

@endsection

@section('css')
    <style type="text/css">
        .Site-content {
            background-image: url("{{ asset('svg/com_index_bg.svg') }}");
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
@endsection