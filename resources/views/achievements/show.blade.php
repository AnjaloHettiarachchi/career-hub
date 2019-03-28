@extends('layouts.main')

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/achievements.show.css') }}">
@endsection

@section('content')
    <div id="container" class="ui raised segment">
        <div class="ui container">
            <h1>
                <a onclick="window.history.back()" href="#">
                    <i class="left arrow circular blue inverted small icon"></i>
                </a>
                {{ $ach_details->ach_title }}
            </h1>
            <span class="meta">
                Achievement by
                <a class="ui image blue image label" href="{{ route('students.home', $stu_details->stu_id) }}">
                    <img class="ui right spaced avatar image"
                         src="data:image/png;base64,{{ chunk_split(base64_encode($stu_details->stu_avatar)) }}"
                         alt="{{ $stu_details->stu_full_name }}">
                    <strong>{{ $stu_details->stu_full_name  }}</strong>
                    <div class="detail">
                        <script type="text/javascript">
                            document.write(moment("{{ $ach_details->created_at }}").format('MMMM Do YYYY, h:mm A'))
                        </script>
                    </div>
                </a>
            </span>
            <br><br>
            <p>{!! nl2br($ach_details->ach_desc) !!}</p>

            <div class="ui dividing header">Skills & Technologies</div>

            <div class="ui inverted blue segment">
                <div class="ui relaxed divided inverted list">

                    @foreach($ach_skills as $skill)

                        <div class="item">
                            <i class="large star yellow middle aligned icon"></i>
                            <div class="content">
                                <div class="ui large header">{{ $skill->skill_title }}</div>
                                <div class="description">{{ $skill->skill_cat_name }}</div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>

        </div>
    </div>
@endsection