@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admins.dashboard.css') }}">
@stop

@section('nav')

    <a class="item" style="background-color: #BD2828" href="{{ route('admins.logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <h4><i class="sign-out icon"></i>LOGOUT</h4>
    </a>
    <form id="logout-form" action="{{ route('admins.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

@endsection

@section('content')

    <div id="container" class="ui clearing raised segment">
        <h1>Admin Dashboard</h1>
        <div class="ui blue statistics">
            <div class="statistic">
                <div class="value">{{ count($stu_list) }}</div>
                <div class="label">Total Students</div>
            </div>
            <div class="statistic">
                <div class="value">{{ count($com_list) }}</div>
                <div class="label">Total Companies</div>
            </div>
            <div class="statistic">
                <div class="value">{{ count($fac_list) }}</div>
                <div class="label">Faculties</div>
            </div>
            <div class="statistic">
                <div class="value">{{ count($dp_list) }}</div>
                <div class="label">Degree Programs</div>
            </div>
            <div class="statistic">
                <div class="value">{{ count($uni_list) }}</div>
                <div class="label">Universities</div>
            </div>
        </div>

        <div class="ui segment">
            <div class="ui dividing huge header">Student Management</div>
            <div class="ui raised three link stackable cards">

                <div class="ui card" onclick="window.location.href='{{ route('admin.sections.student') }}'">
                    <div class="image">
                        <img src="{{ asset('png/stu_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Student Accounts</div>
                    </div>
                    <div class="extra content">
                        {{ count($stu_list) }} Students
                    </div>
                </div>

                <div class="ui card" onclick="window.location.href='{{ route('stuIdTypes.index') }}'">
                    <div class="image">
                        <img src="{{ asset('png/sit_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Student ID Types</div>
                    </div>
                    <div class="extra content">
                        {{ count($sit_list) }} Student ID Types
                    </div>
                </div>

                <div class="ui card" onclick="window.location.href='{{ route('faculties.index') }}'">
                    <div class="image">
                        <img src="{{ asset('png/fac_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Faculties</div>
                    </div>
                    <div class="extra content">
                        {{ count($fac_list) }} Faculties
                    </div>
                </div>

                <div class="ui card" onclick="window.location.href='{{ route('universities.index') }}'">
                    <div class="image">
                        <img src="{{ asset('png/uni_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Universities</div>
                    </div>
                    <div class="extra content">
                        {{ count($uni_list) }} Universities
                    </div>
                </div>

                <div class="ui card" onclick="window.location.href='{{ route('degreePrograms.index') }}'">
                    <div class="image">
                        <img src="{{ asset('png/degree_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Degree Programs</div>
                    </div>
                    <div class="extra content">
                        {{ count($dp_list) }} Degree Programs
                    </div>
                </div>

            </div>

            <div class="ui dividing huge header">Company Management</div>
            <div class="ui raised three link stackable cards">

                <div class="ui card" onclick="window.location.href='{{ route('admin.sections.companies') }}'">
                    <div class="image">
                        <img src="{{ asset('png/com_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">All Companies</div>
                    </div>
                    <div class="extra content">
                        {{ count($com_list) }} Companies
                    </div>
                </div>

                <div class="ui card">
                    <div class="image">
                        <img src="{{ asset('png/aoe_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Areas of Expertise</div>
                    </div>
                    <div class="extra content">
                        {{ count($aoe_list) }} Areas of Expertise
                    </div>
                </div>

            </div>

            <div class="ui dividing huge header">Skill Management</div>
            <div class="ui raised three link stackable cards">

                <div class="ui card">
                    <div class="image">
                        <img src="{{ asset('png/skills_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Skills</div>
                    </div>
                    <div class="extra content">
                        {{ count($skill_list) }} Skills
                    </div>
                </div>

                <div class="ui card">
                    <div class="image">
                        <img src="{{ asset('png/skill_cat_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Skill Categories</div>
                    </div>
                    <div class="extra content">
                        {{ count($skill_cat_list) }} Skill Categories
                    </div>
                </div>

            </div>

            <div class="ui dividing huge header">User Management</div>
            <div class="ui raised three link stackable cards">

                <div class="ui card">
                    <div class="image">
                        <img src="{{ asset('png/stu_user_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Students</div>
                    </div>
                    <div class="extra content">
                        {{ count($stu_user_list) }} Student User
                    </div>
                </div>

                <div class="ui card">
                    <div class="image">
                        <img src="{{ asset('png/com_user_banner.jpg') }}" alt="image">
                    </div>
                    <div class="content">
                        <div class="ui huge header">Companies</div>
                    </div>
                    <div class="extra content">
                        {{ count($com_user_list) }} Company User
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection