@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/company.home.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('js/company.home.js') }}"></script>
@endsection

@section('nav')

    @auth('company')

        <a class="item" style="background-color: #BD2828" href="{{ route('companies.logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <h4><i class="sign-out icon"></i>LOGOUT</h4>
        </a>
        <form id="logout-form" action="{{ route('companies.logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    @endauth

@endsection

@section('content')
    <div id="container" class="ui segment">

        <div class="ui three column middle aligned stackable divided grid">

            <div class="column">
                <h1 class="ui center aligned icon header">
                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($com_details->com_avatar)) }}"
                         alt="{{ $com_details->com_title }}" class="ui circular image icon">
                    {{ $com_details->com_title }}
                    <div class="sub header">{{ $com_aoe }}</div>
                </h1>
            </div>

            <div class="center aligned column">
                <div class="ui icon blue header">
                    <i class="map marker alternate icon"></i>Location
                </div>
                <br>
                <span>{!! nl2br(e($com_details->com_address . '.')) !!}</span>
            </div>

            <div class="center aligned column">
                <div class="ui icon blue header">
                    <i class="info circle icon"></i>About
                </div>
                <p>{{ $com_details->com_desc }}</p>
            </div>

        </div>

        <div class="ui secondary pointing blue stackable menu">
            <a class="item active">
                <i class="home icon"></i>
                Home
            </a>
            <a class="item">
                <i class="comments icon"></i>
                Conversations
            </a>
            <a class="item">
                <i class="users icon"></i>
                Opportunities
            </a>
            <a class="item">
                <i class="search icon"></i>
                Find Candidates
            </a>
            <div class="right menu">
                <a class="ui item">
                    <i class="cogs icon"></i>
                    Account Settings
                </a>
            </div>
        </div>

        <div id="home-content" class="ui content-div segment">
            <h1>Home</h1>
        </div>
        <div id="con-content" class="ui content-div segment">
            <h1>Conversations</h1>
        </div>
        <div id="op-content" class="ui content-div segment">
            <h1>Opportunities</h1>
        </div>
        <div id="find-content" class="ui content-div segment">
            <h1>Find Candidates</h1>
        </div>
        <div id="settings-content" class="ui content-div segment">
            <h1>Account Settings</h1>
        </div>

    </div>
@endsection