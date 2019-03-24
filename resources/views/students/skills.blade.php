@extends('layouts.main')

@section('js')
    <script type="text/javascript" src="{{ asset('js/student.skills.js') }}"></script>
    @if (count($stu_skills) > 0)
        <script type="text/javascript">
            $(document).ready(() => {
                $('#skill-list').val('{{ $skill_array }}');
                console.log($('#skill-list').val());
            })
        </script>
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/student.skills.css') }}">
@endsection

@section('content')

    <div id="container" class="ui clearing raised segment">
        <div class="ui blue massive ribbon label">
            <span>Skills for</span>
            <br>{{ $stu_details->stu_full_name }}
        </div>
        <h1>Student<i class="angle right icon"></i>Skills</h1>
        <div class="ui info icon message">
            <i class="info circle icon"></i>
            <div class="content">
                <p>
                    You can define your skills and competence levels from below. You can
                    search for skills and can define competence levels after adding them to the list.
                </p>
            </div>
        </div>

        <form action="{{ route('students.saveSkills') }}" method="POST" class="ui form">

            {{ csrf_field() }}

            <div class="ui top attached segment">
                <div class="ui fluid search">
                    <div class="ui icon fluid input">
                        <input class="prompt" type="text" placeholder="Search Skills...">
                        <i class="search icon"></i>
                    </div>
                    <div class="results"></div>
                </div>
            </div>

            @if (count($stu_skills) > 0)

                <div id="skill-container" class="ui middle attached segment">
                    <table id="skill-table" class="ui selection table">
                        <tbody>

                        @foreach($stu_skills as $skill)

                            <tr data-index="{{ $skill->skill_id }}">
                                <td>
                                    <span style="font-size: x-large;font-weight: bold">{{ $skill->skill_title }}</span><br>
                                    <small style="color: grey">{{ $skill->skill_cat_name }}</small>
                                </td>
                                <td class="center aligned">
                                    <script type="text/javascript">
                                        document.write(makeLevelLabel({{ $skill->stu_skill_level }}))
                                    </script>
                                </td>
                                <td class="right aligned">
                                    <button type="button" class="ui red left icon button" onclick="removeSkill(this)">
                                        <i class="times icon"></i>
                                    </button>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>

            @else

                <div id="skill-container" class="ui middle attached placeholder segment">
                    <div class="ui icon header">
                        <i class="orange exclamation triangle icon"></i>
                        No Skills are listed yet.
                    </div>
                </div>

            @endif

            <div class="ui bottom attached clearing segment">
                <input type="hidden" id="skill-list" name="skill-list" value="">
                <button type="reset" name="reset" id="reset" class="ui right floated left icon labeled disabled button">
                    <i class="undo icon"></i> Reset Skills
                </button>
                <button type="submit" name="add" id="add"
                        class="ui right floated green left icon labeled disabled button">
                    <i class="save icon"></i> Save Skills
                </button>
            </div>
        </form>

    </div>

@endsection