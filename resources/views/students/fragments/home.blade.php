<div id="home-content" class="ui content-div segment">
    <h1>Home</h1>

    @if (count($stu_skills) > 0 || count($stu_achs) > 0)

        <div class="ui dividing header">Recent Activities</div>

        @if (count($stu_skills) > 0)


            <div class="ui feed">
                <div class="event">
                    <div class="label">
                        <i class="star circular inverted blue middle aligned icon"></i>
                    </div>
                    <div class="content">
                        <div class="summary">
                            Your skill listing is completed. Now you have <a onclick="showTab('skill')">{{ count($stu_skills) }} skills</a>.
                            <div class="date">
                                <script type="text/javascript">
                                    document.write(moment("{{ $stu_skills->toArray()[0]->updated_at }}").fromNow())
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        @if (count($stu_achs) > 0)

            @foreach($stu_achs as $ach)

                <div class="ui feed">
                    <div class="event">
                        <div class="label">
                            <i class="trophy circular inverted blue middle aligned icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                You have posted an new Achievement as <a href="{{ route('achievements.show', $ach->ach_id) }}">{{ $ach->ach_title }}</a>.
                                <div class="date">
                                    <script type="text/javascript">
                                        document.write(moment("{{ $ach->created_at }}").fromNow())
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

        @endif

    @else

        <div class="ui placeholder center aligned segment">
            <div class="ui icon large header">
                <i class="home icon"></i>
                Welcome to your {{ env('APP_NAME') }} Student Profile.
            </div>
            <p>
                You can show your potential to the industry from here. You can update your Skills & Achievements <br>
                and
                find most suitable career opportunities for you based on them. Wish you the very best. <br>
                ~ Admin Team
            </p>
        </div>

    @endif

</div>