<div id="ach-content" class="ui content-div segment">
    <h1>Skills & Achievements</h1>

    <div class="ui dividing header">Skills</div>
    @if (count($stu_skills) > 0)

        <div class="ui top attached segment">

            <div class="ui relaxed divided list">

                @foreach($stu_skills as $skill)
                    <div class="item">
                        <i class="yellow star big middle aligned icon"></i>
                        <div class="content">
                            <div class="ui big header">
                                <span style="color: grey">{{ $skill->skill_cat_name }}<i class="angle right icon"></i></span>{{ $skill->skill_title }}
                            </div>
                            <div class="description">
                                <div class="ui indicating progress" data-value="{{ $skill->stu_skill_level }}" data-total="6">
                                    <div class="bar"></div>
                                    <div class="prog label">Competence Level: </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
        <div class="ui bottom attached segment">
            <a class="ui primary left icon fluid button" href="{{ route('students.showSkills') }}">
                <i class="edit icon"></i> Edit Skills
            </a>
        </div>

    @else
        <div class="ui placeholder center aligned segment">
            <div class="ui icon header">
                <i class="star icon"></i>
                There are no skills listed.
            </div>
            <p>Your skills will be used to find suitable career opportunities for you.
                So let's start by adding some new Skills.</p>
            <a class="ui primary button" href="{{ route('students.showSkills') }}">Add Skills</a>
        </div>
    @endif

    <div class="ui dividing header">Achievements</div>
    <div class="ui placeholder center aligned segment">
        <div class="ui icon header">
            <i class="trophy icon"></i>
            You have not posted any achievements yet.
        </div>
        <p>Your achievements will be used to find suitable career opportunities for you.
            So let's start by adding some new Achievements.</p>
        <a class="ui primary button" href="{{ route('achievements.create') }}">Add Achievements</a>
    </div>

</div>