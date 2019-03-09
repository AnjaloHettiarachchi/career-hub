@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/company.create.css') }}">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/company.create.js') }}"></script>
@endsection

@section('nav')

    <a class="item" style="background-color: #BD2828" href="{{ route('companies.logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <h4><i class="sign-out icon"></i>LOGOUT</h4>
    </a>
    <form id="logout-form" action="{{ route('companies.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

@endsection

@section('content')

    <div id="container" class="ui clearing segment">

        <h1><i class="far fa-building icon"></i>Company<i class="angle right icon"></i>Create Account</h1>
        <p>Provide necessary information and complete your company's account.</p>

        @include('includes.messages')

        <form action="{{ route('companies.doCreate') }}" method="POST" class="ui form" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="inline fields {{ $errors->has('avatar') ? 'error' : '' }}">
                <div class="field">
                    <img id="avatar-preview" class="ui tiny fluid circular image" src="{{ asset('png/img_avatar.png') }}"
                         alt="avatar">
                </div>
                <div class="field">
                    <input type="file" name="avatar" id="avatar" accept="[image/jpeg][image/png]" value="{{ old('avatar') }}">
                </div>
            </div>

            <div class="input field {{ $errors->has('aoe') ? 'error' : '' }}">
                <label for="aoe">Company's Area of Expertise</label>
                <select class="ui dropdown" id="aoe" name="aoe">
                    <option value="">Select your Company's Area of Expertise</option>
                    @foreach(DB::table('areas_of_expertise')->get() as $aoe)
                        <option value="{{ $aoe->aoe_id }}">{{ $aoe->aoe_name }}</option>
                    @endforeach
                    <option value="0">Other</option>
                </select>
            </div>

            <div id="div-aoe-alt" class="input field {{ $errors->has('aoe_alt') ? 'error' : '' }}">
                <label for="aoe_alt">Alternate Area of Expertise</label>
                <input type="text" name="aoe_alt" id="aoe_alt" placeholder="Define your company's Area of Expertise" value="{{ old('aoe_alt') }}">
            </div>

            <div class="input field {{ $errors->has('title') ? 'error' : '' }}">
                <label for="title">Company Title</label>
                <input type="text" name="title" id="title" placeholder="Example Company PLC" value="{{ old('title') }}">
            </div>

            <div class="input field {{ $errors->has('desc') ? 'error' : '' }}">
                <label for="desc">Company Description</label>
                <textarea name="desc" id="desc" placeholder="Provide a short description about your company..." rows="3">{{ old('desc') }}</textarea>
            </div>

            <div class="input field {{ $errors->has('address') ? 'error' : '' }}">
                <label for="address">Company Address</label>
                <textarea name="address" id="address" placeholder="No.01&#x0a;Example Lane&#x0a;Example City" rows="3">{{ old('address') }}</textarea>
            </div>

            <button class="ui labeled icon primary right floated button">
                <i class="far fa-building icon"></i> Create Account
            </button>

        </form>

    </div>

@endsection