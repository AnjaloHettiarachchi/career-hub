@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.register.css') }}">
@endsection

@section('content')
    <div id="container" class="ui clearing segment">
        <h1>Admin <i class="angle right icon"></i> Register</h1>
        <p>Provide relevant details to create a new admin account.</p>

        @include('includes.messages')

        <form action="{{ route('admins.doRegister') }}" method="POST" class="ui form">

            {{ csrf_field() }}

            <div class="field {{ $errors->has('admin_name') ? 'error' : '' }}">
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" placeholder="Username (i.e. john_doe)" name="admin_name" id="admin_name"
                           value="{{ old('admin_name') }}" required>
                </div>

            </div>

            <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                <div class="ui left icon input">
                    <i class="key icon"></i>
                    <input type="password" placeholder="Password" name="password" id="password" required>
                </div>

            </div>

            <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                <div class="ui left icon input">
                    <i class="key icon"></i>
                    <input type="password" placeholder="Confirm Password" name="password_confirmation"
                           id="password_confirmation" required>
                </div>
                <span class=""><strong>Note:</strong> Password must contain <strong>at least 8</strong> characters.</span>
            </div>

            <button class="ui labeled icon green right floated button">
                <i class="user plus icon"></i> Register
            </button>

        </form>

    </div>
@endsection