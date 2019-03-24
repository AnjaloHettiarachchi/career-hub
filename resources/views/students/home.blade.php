@extends('layouts.main')

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript" src="{{ asset('js/students.home.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/students.home.css') }}">
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
    <div id="container" class="ui raised clearing segment">

        <div class="ui two column middle aligned stackable divided grid">

            <div class="column">
                <h1 class="ui center aligned icon header">
                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($stu_details->stu_avatar)) }}"
                         alt="{{ $stu_details->stu_full_name }}" class="ui circular image icon">
                    {{ $stu_details->stu_full_name }}
                    <div class="sub header">
                        {{ $stu_details->stu_prov_id }} • {{ $stu_details->fac_name }}<br>
                        {{ $stu_details->deg_title }} by {{ $stu_details->uni_title }}
                    </div>
                </h1>
            </div>

            <div class="center aligned column">
                <div class="ui icon blue header">
                    <i class="info circle icon"></i>About me
                </div>
                <p>{{ $stu_details->stu_bio }}</p>
            </div>

        </div>

        <div id="main-menu" class="ui secondary pointing blue stackable menu">
            <a class="home item active">
                <i class="home icon"></i>
                Home
            </a>
            <a class="con item">
                <i class="comments icon"></i>
                Conversations
            </a>
            <a class="ach item">
                <i class="trophy icon"></i>
                Skills & Achievements
            </a>
            <a class="find item">
                <i class="search icon"></i>
                Find Opportunities
            </a>
            <div id="main-menu-right" class="right menu">
                <a class="settings item">
                    <i class="cogs icon"></i>
                    Account Settings
                </a>
            </div>
        </div>

        @include('students.fragments.home', ['stu_skills' => $stu_skills])

        @include('students.fragments.conversations')

        @include('students.fragments.achievements', ['stu_skills' => $stu_skills])

        @include('students.fragments.opportunities')

        @include('students.fragments.settings')

    </div>
@endsection