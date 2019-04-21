@extends('layouts.main')

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript" src="{{ asset('js/students.home.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(() => {
            $('#fac').dropdown('set selected', {{ $stu_details->fac_id }}).addClass('disabled');
            $('#uni').dropdown('set selected', {{ $stu_details->uni_id }}).addClass('disabled');
            $('#sit').dropdown('set selected', {{ $stu_details->sit_id }})
        })
    </script>

    {{-- Firebase --}}
    <script src="https://www.gstatic.com/firebasejs/5.9.1/firebase.js"></script>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/students.home.css') }}">
@endsection

@section('nav')

    @auth('student')

        <a class="item" style="background-color: #BD2828" href="{{ route('students.logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <h4><i class="sign-out icon"></i>LOGOUT</h4>
        </a>
        <form id="logout-form" action="{{ route('students.logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    @endauth

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

        <br>

        @auth('student')
            <div id="main-search" class="ui fluid search">
                <div class="ui icon fluid input">
                    <input class="prompt" type="text" placeholder="Search for a company..." autofocus>
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        @endauth

        <div id="main-menu" class="ui secondary pointing blue stackable menu">

            @auth('student')

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
                        <i class="cog icon"></i>
                        Settings
                    </a>
                </div>

            @elseauth('company')

                <script type="text/javascript">

                    $(document).ready(() => {
                        $('#ach-content').css('display', 'block');
                        $('.ach.item').addClass('active')
                    })

                </script>

                <a class="ach item">
                    <i class="trophy icon"></i>
                    Skills & Achievements
                </a>

            @endauth

        </div>

        @auth('student')

            @include('students.fragments.home', ['stu_skills' => $stu_skills,
                                                    'stu_achs' => $stu_achs,
                                                    'stu_con_list' => $stu_con_list ])

            @include('students.fragments.conversations', ['stu_details' => $stu_details,
                                                            'com_list', $com_list,
                                                            'stu_con_list', $stu_con_list ])

            @include('students.fragments.achievements', ['stu_skills' => $stu_skills,
                                                            'stu_achs' => $stu_achs,
                                                            'stu_ach_skills' => $stu_ach_skills ])

            @include('students.fragments.opportunities', ['op_list', $op_list ])

            @include('students.fragments.settings', ['stu_details' => $stu_details,
                                                        'fac_list' => $fac_list,
                                                        'uni_list' => $uni_list,
                                                        'sit_list' => $sit_list ])

        @elseauth('company')

            @include('students.fragments.achievements', ['stu_skills' => $stu_skills,
                                                        'stu_achs' => $stu_achs,
                                                        'stu_ach_skills' => $stu_ach_skills ])

        @endauth

    </div>
@endsection