@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/company.login.css') }}">
@endsection

@section('content')
    <div id="container" class="ui centered clearing raised card">
        <div class="image">
            <img src="{{ asset('png/com_banner.jpg') }}" alt="Company">
        </div>
        <div class="content">
            <h1 class="header">Company<i class="angle right icon"></i>Sign in</h1>
            <p class="meta">Provide necessary credentials to login to your company's account.</p>

            @include('includes.messages')

            <form action="{{ route('companies.doLogin') }}" method="POST" class="ui form">

                {{ csrf_field() }}

                <div class="field {{ $errors->has('company_user_name') ? 'error' : '' }}">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" placeholder="Username" name="company_user_name" id="company_user_name"
                               value="{{ old('company_user_name') }}">
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