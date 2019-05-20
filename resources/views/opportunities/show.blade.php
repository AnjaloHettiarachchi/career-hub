@extends('layouts.main')

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript" src="{{ asset("js/opportunities.show.js") }}"></script>

    @auth('company')
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#candidates').DataTable();
            });

        </script>
    @endauth

@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
    <link rel="stylesheet" href="{{ asset('css/opportunity.show.css') }}">
@endsection

@section('content')
    <div id="container" class="ui raised segment">
        <div class="ui container">
            <h1>
                <a onclick="window.history.back()" href="#">
                    <i class="left arrow circular blue inverted small icon"></i>
                </a>
                {{ $op_details->op_title }}
            </h1>
            <span class="meta">
                An opportunity by
                <a class="ui image blue image label" href="{{ route('companies.home', $com_details->com_id) }}">
                    <img class="ui right spaced avatar image"
                         src="data:image/png;base64,{{ chunk_split(base64_encode($com_details->com_avatar)) }}"
                         alt="{{ $com_details->com_title }}">
                    <strong>{{ $com_details->com_title  }}</strong>
                    <div class="detail">
                        <script type="text/javascript">
                            document.write(moment("{{ $op_details->created_at }}").format('MMMM Do YYYY, h:mm A'))
                        </script>
                    </div>
                </a>
            </span>
            <br><br>
            <p>{!! nl2br($op_details->op_desc) !!}</p>

            @auth('company')

                <div class="ui top attached tabular menu" id="tab-set">
                    <a class="item active" data-tab="first"><i class="trophy icon"></i>Required Skills</a>
                    <a class="item" data-tab="second"><i class="search icon"></i>Find Candidates</a>
                </div>
                <div class="ui bottom attached tab segment active" data-tab="first">
                    <table class="ui inverted blue table">
                        <tbody>

                        @foreach($op_skills as $skill)

                            <tr class="center aligned">
                                <td>
                                    <div class="ui huge inverted header">{{ $skill->skill_title }}</div>
                                    <small>{{ $skill->skill_cat_name }}</small>
                                </td>
                                <td>
                                    @switch($skill->op_skill_level)
                                        @case(1)
                                        Competence Level:
                                        <div class="ui label">Basic</div>
                                        @break
                                        @case(2)
                                        Competence Level:
                                        <div class="ui yellow label">Novice</div>
                                        @break
                                        @case(3)
                                        Competence Level:
                                        <div class="ui olive label">Intermediate</div>
                                        @break
                                        @case(4)
                                        Competence Level:
                                        <div class="ui green label">Advance</div>
                                        @break
                                        @default
                                        Competence Level:
                                        <div class="ui blue label">Expert</div>
                                        @break
                                    @endswitch
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="ui bottom attached tab segment" data-tab="second">
                    <h1>Suitable Candidates</h1>
                    <p>We found and ranked following opportunities as most suitable for you based on the skills you have mentioned in
                        <b>Skills & Achievements</b>.
                    </p>

                    <div class="ui inverted blue segment">

                        <table id="candidates" class="ui selectable inverted blue table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Avatar</th>
                                <th>Student</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($candi_list as $candidates)
                                @php $num = $loop->iteration @endphp
                                @foreach($candidates as $candidate)
                                    <tr onclick="window.location.href='{{ route('students.home', $candidate->stu_id) }}'">
                                        <td class="center aligned one wide">
                                            <h1>{{ $num }}</h1>
                                        </td>
                                        <td class="one wide">
                                            <img class="ui rounded medium image"
                                                 src="data:image/png;base64,{{ chunk_split(base64_encode($candidate->stu_avatar)) }}"
                                                 alt="stu_avatar">
                                        </td>
                                        <td>
                                            <h1>{{ $candidate->stu_full_name }}</h1>
                                            @if ($candidate->uni_id == 5)
                                                <i class="graduation hat icon"></i> {{ $candidate->deg_title }} - approved by University Grant Commission, Sri Lanka
                                            @else
                                                <i class="graduation hat icon"></i> {{ $candidate->deg_title }} • {{ $candidate->uni_title }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

                            </tbody>
                        </table>

                </div>

            @elseauth('student')

                <h2 class="ui dividing header">Required Skills</h2>
                <table class="ui inverted blue table">
                    <tbody>

                    @foreach($op_skills as $skill)

                        <tr class="center aligned">
                            <td>
                                <div class="ui huge inverted header">{{ $skill->skill_title }}</div>
                                <small>{{ $skill->skill_cat_name }}</small>
                            </td>
                            <td>
                                @switch($skill->op_skill_level)
                                    @case(1)
                                    Competence Level:
                                    <div class="ui label">Basic</div>
                                    @break
                                    @case(2)
                                    Competence Level:
                                    <div class="ui yellow label">Novice</div>
                                    @break
                                    @case(3)
                                    Competence Level:
                                    <div class="ui olive label">Intermediate</div>
                                    @break
                                    @case(4)
                                    Competence Level:
                                    <div class="ui green label">Advance</div>
                                    @break
                                    @default
                                    Competence Level:
                                    <div class="ui blue label">Expert</div>
                                    @break
                                @endswitch
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

            @endauth

        </div>
    </div>
@endsection