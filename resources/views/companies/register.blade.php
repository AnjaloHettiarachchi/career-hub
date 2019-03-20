@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/company.register.css') }}">
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
        <h1>Company <i class="angle right icon"></i> Register</h1>
        <p>Provide relevant details to create a new account for your company.</p>

        @include('includes.messages')

        <form action="{{ route('companies.doRegister') }}" method="POST" class="ui form">

            {{ csrf_field() }}

            <div class="field {{ $errors->has('com_name') ? 'error' : '' }}">
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" placeholder="Username (i.e. abc_company)" name="com_name" id="com_name"
                           value="{{ old('com_name') }}" required>
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