@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/company.home.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript" src="{{ asset('js/company.home.js') }}"></script>
    {{-- Firebase --}}
    <script src="https://www.gstatic.com/firebasejs/5.9.1/firebase.js"></script>

    @auth('student')

        <script type="text/javascript">
            $(document).ready(function () {
                $('#request').on('click', function () {

                    $('#request-modal')
                        .modal({
                            closable: false,
                            onApprove: function () {
                                let stu_id = {!! $stu_visitor->stu_id !!};
                                let com_id = {!! $com_details->com_id !!};

                                $('#loader-modal')
                                    .modal({closable: false})
                                    .modal('show');

                                $.ajax({
                                    url: '/student/generate',
                                    method: 'GET',
                                    data: {stu_id: stu_id, com_id: com_id},
                                    dataType: 'JSON',
                                    success: function (res) {
                                        $('#loader-modal').modal('close');

                                        if (res.hasOwnProperty('success')) {
                                            $('#success-modal').modal('show');
                                        } else {
                                            $('#error-modal').modal('show');
                                        }
                                    }
                                })

                            }
                        }).modal('show');

                });
            })
        </script>

    @endauth

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
    <div id="container" class="ui raised clearing segment">

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
        <br>
        <br>

        @auth('student')

            <div class="ui centered fluid grid">
                <button id="request" class="ui left labeled icon green big button">
                    <i class="file alternate icon"></i>Request a letter for {{ $com_details->com_title }}
                </button>
            </div>

            <div id="request-modal" class="ui modal">
                <i class="close icon"></i>
                <div class="header">Request a letter for {{ $com_details->com_title }}</div>
                <div class="scrolling content">
                    <p>
                        A Request Letter will be generated using following information and will be sent to your
                        email address <b>{{ $stu_visitor->stu_email }}</b>. Carefully review following information
                        before
                        confirm your request.
                    </p>
                    <table class="ui inverted blue table">
                        <tr>
                            <th colspan="2">
                                <h1 style="padding: 1%; text-align: center">
                                    <i class="building icon"></i> Company/Organization Information
                                </h1>
                            </th>
                        </tr>
                        <tr>
                            <td class="three wide"><b>Addressed to:</b></td>
                            <td>Manager - Human Resources</td>
                        </tr>
                        <tr>
                            <td><b>Title:</b></td>
                            <td>{{ $com_details->com_title }}</td>
                        </tr>
                        <tr>
                            <td><b>Address:</b></td>
                            <td>{!! nl2br(e($com_details->com_address . '.')) !!}</td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <h1 style="padding: 1%; text-align: center">
                                    <i class="graduation hat icon"></i> Student Information
                                </h1>
                            </th>
                        </tr>
                        <tr>
                            <td><b>Title:</b></td>
                            <td>{{ $stu_visitor->stu_full_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Degree Program:</b></td>
                            @if ($stu_visitor->uni_id == 5)
                                <td>{{ $stu_visitor->deg_title }} - approved by University Grant Commission, Sri Lanka
                                </td>
                            @else
                                <td>{{ $stu_visitor->deg_title }} - offered in affiliation
                                    with {{ $stu_visitor->uni_title }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Student ID:</b></td>
                            <td>{{ $stu_visitor->stu_prov_id }}</td>
                        </tr>
                    </table>
                </div>
                <div class="actions">
                    <button class="ui negative button">Cancel</button>
                    <button class="ui positive left labeled icon button">
                        <i class="check icon"></i>Confirm Request
                    </button>
                </div>
            </div>

            <div id="loader-modal" class="ui basic modal">
                <div class="ui inline large centered text loader"><h1>Generating a Request Letter...</h1></div>
            </div>

            <div id="success-modal" class="ui basic modal">
                <div class="ui icon huge header">
                    <i class="green check circle outline icon"></i>
                    <h1>Letter has been generated successfully</h1>
                </div>
                <div class="content">
                    The letter you have requested for {{ $com_details->com_title }} is successfully generated
                    and have been send to your email address (<b>{{ $stu_visitor->stu_email }}</b>).
                </div>
                <div class="actions">
                    <div class="ui green ok inverted button">
                        <i class="checkmark icon"></i>
                        OK
                    </div>
                </div>
            </div>

            <div id="error-modal" class="ui basic modal">
                <div class="ui icon huge header">
                    <i class="red frown icon"></i>
                    <h1>Oops! Something went wrong</h1>
                </div>
                <div class="content">
                    An error occurred while generating your letter for {{ $com_details->com_title }}.
                    Please try again later. If you getting this message again contact NSBM Career Guidance Unit
                    for further assistance.
                </div>
                <div class="actions">
                    <div class="ui green ok inverted button">
                        <i class="checkmark icon"></i>
                        OK
                    </div>
                </div>
            </div>

        @endauth

        @auth('company')
            <div id="main-search" class="ui fluid search">
                <div class="ui icon fluid input">
                    <input class="prompt" type="text" placeholder="Search for a student..." autofocus>
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        @endauth

        <div id="main-menu" class="ui secondary pointing blue stackable menu">
            @auth('company')

                <a class="home item active">
                    <i class="home icon"></i>
                    Home
                </a>
                <a class="con item">
                    <i class="comments icon"></i>
                    Conversations
                </a>
                <a class="op item">
                    <i class="users icon"></i>
                    Opportunities
                </a>
                <div id="main-menu-right" class="right menu">
                    <a class="settings item">
                        <i class="cog icon"></i>
                        Settings
                    </a>
                </div>

            @elseauth('student')

                <script type="text/javascript">

                    $(document).ready(() => {
                        $('#op-content').css('display', 'block');
                        $('.op.item').addClass('active')
                    })

                </script>

                <a class="op item">
                    <i class="users icon"></i>
                    Opportunities
                </a>

            @endauth
        </div>

        @auth('company')

            @include('companies.fragments.home', ['com_ops' => $com_ops])

            @include('companies.fragments.conversations', ['com_details' => $com_details,
                                                            'stu_list' => $stu_list,
                                                            'com_con_list' => $com_con_list])

            @include('companies.fragments.opportunities', ['com_ops' => $com_ops])

            @include('companies.fragments.settings', ['aoe_list' => $aoe_list,
                                                        'com_details', $com_details])

        @elseauth('student')

            @include('companies.fragments.opportunities', ['com_ops' => $com_ops])

        @endauth

    </div>
@endsection