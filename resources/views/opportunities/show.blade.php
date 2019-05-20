@extends('layouts.main')

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript" src="{{ asset("js/opportunities.show.js") }}"></script>
@endsection

@section('css')
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
                                    Competence Level: <div class="ui label">Basic</div>
                                    @break
                                    @case(2)
                                    Competence Level: <div class="ui yellow label">Novice</div>
                                    @break
                                    @case(3)
                                    Competence Level: <div class="ui olive label">Intermediate</div>
                                    @break
                                    @case(4)
                                    Competence Level: <div class="ui green label">Advance</div>
                                    @break
                                    @default
                                    Competence Level: <div class="ui blue label">Expert</div>
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
            </div>

        </div>
    </div>
@endsection