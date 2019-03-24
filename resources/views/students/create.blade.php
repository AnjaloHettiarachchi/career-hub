@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/student.create.css') }}">
@endsection

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
    <script type="text/javascript" src="{{ asset('js/student.create.js') }}"></script>
@endsection

@section('nav')

    <a class="item" style="background-color: #BD2828" href="{{ route('students.logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <h4><i class="sign-out icon"></i>LOGOUT</h4>
    </a>
    <form id="logout-form" action="{{ route('students.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

@endsection

@section('content')
    <div id="container" class="ui clearing raised segment">
        <h1><i class="fas fa-graduation-cap icon"></i> Student<i class="angle right icon"></i>Create Account</h1>
        <p>Provide necessary information and complete your student account.</p>

        @include('includes.messages')

        <form action="{{ route('students.doCreate') }}" method="POST" class="ui form" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="ui grid">
                <div class="ui two wide column">
                    <img id="avatar-preview" class="ui tiny fluid circular image"
                         src="{{ asset('png/stu_avatar.png') }}"
                         alt="avatar">
                </div>
                <div class="ui six wide column">
                    <div class="field {{ $errors->has('avatar') ? 'error' : '' }}">
                        <label for="avatar">Select an avatar for your account (Optional)</label>
                        <input type="file" name="avatar" id="avatar" accept="[image/jpeg][image/png]"
                               value="{{ old('avatar') }}">
                    </div>
                </div>
            </div>
            <br>

            <div class="field" id="fac-field">
                <label for="fac">Faculty</label>
                <select name="fac" id="fac">
                    <option value="">Select your Faculty</option>
                    @foreach ($fac_list as $fac)
                        <option value="{{ $fac->fac_id }}">{{ $fac->fac_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field" id="uni-field">
                <label for="uni">University</label>
                <select name="uni" id="uni">
                    <option value="">Select your University</option>
                    @foreach ($uni_list as $uni)
                        <option value="{{ $uni->uni_id }}">{{ $uni->uni_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field {{ $errors->has('deg') ? 'error' : '' }}">
                <label for="deg">Degree Program</label>
                <div class="ui category fluid search">
                    <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="Search for your Degree Program">
                        <input type="hidden" name="deg" id="deg">
                        <i class="search icon"></i>
                    </div>
                    <div class="results"></div>
                </div>
            </div>

            <div class="field {{ $errors->has('sit') ? 'error' : '' }}">
                <label for="sit">ID Card Type</label>
                <select name="sit" id="sit">
                    <option value="">Select your Student ID Card Type</option>
                    @foreach ($sit_list as $sit)
                        <option value="{{ $sit->sit_id }}">{{ $sit->sit_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field {{ $errors->has('stu_prov_id') ? 'error' : '' }}" id="prov-id-field">
                <label for="stu_prov_id">ID Card No.</label>
                <div class="ui input">
                    <input type="text" placeholder="Student ID No." name="stu_prov_id" id="stu_prov_id"
                           value="{{ old('stu_prov_id') }}">
                </div>
            </div>

            <div class="field {{ $errors->has('full_name') ? 'error' : '' }}">
                <label for="full_name">Full Name</label>
                <div class="ui input">
                    <input type="text" placeholder="Student Full Name" name="full_name" id="full_name"
                           value="{{ old('full_name') }}">
                </div>
            </div>

            <div class="field {{ $errors->has('bio') ? 'error' : '' }}">
                <label for="bio">Biography</label>
                <div class="ui input">
                    <textarea type="text" placeholder="A small summary about yourself..." name="bio" id="bio">{{ old('bio') }}</textarea>
                </div>
            </div>

            <div class="field {{ $errors->has('con_num') ? 'error' : '' }}">
                <label for="con_num">Contact No.</label>
                <div class="ui input">
                    <input type="text" placeholder="Student Contact No." name="con_num" id="con_num"
                           value="{{ old('con_num') }}">
                </div>
            </div>

            <div class="field {{ $errors->has('stu_email') ? 'error' : '' }}">
                <label for="stu_email">Email Address</label>
                <div class="ui input">
                    <input type="email" placeholder="Student Email Address" name="stu_email" id="stu_email"
                           value="{{ old('stu_email') }}">
                </div>
            </div>

            <button type="submit" class="ui green right floated left icon labeled button">
                <i class="plus icon"></i>Create Student Account
            </button>

        </form>

    </div>
@endsection