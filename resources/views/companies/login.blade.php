@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.login.css') }}">
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.close.icon').on('click', function () {
                    $(this).closest('.message').transition('fade down');
                }
            );
        });
    </script>
@endsection

@section('content')
    <div id="container" class="ui clearing segment">
        <h1>Company <i class="angle right icon"></i> Login</h1>
        <p>Provide necessary credentials to login to your company's account.</p>

        @include('includes.messages')

        <form action="{{ route('companies.doLogin') }}" method="POST" class="ui form">

            {{ csrf_field() }}

            <div class="field {{ $errors->has('company_user_name') ? 'error' : '' }}">
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" placeholder="Username" name="admin_name" id="admin_name"
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
                <i class="sign-in icon"></i> Login
            </button>

        </form>

    </div>
@endsection