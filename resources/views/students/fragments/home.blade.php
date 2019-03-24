<div id="home-content" class="ui content-div segment">
    <h1>Home</h1>

    @if (count($stu_skills) > 0)

        <div class="ui dividing header">Recent Activities</div>
        <div class="ui feed">
            <div class="event">
                <div class="label">
                    <i class="star circular inverted blue middle aligned icon"></i>
                </div>
                <div class="content">
                    <div class="summary">
                        Your skill listing is completed. Now you have <a>{{ count($stu_skills) }} skills</a>.
                        <div class="date">
                            <script type="text/javascript">
                                document.write(moment("{{ $stu_skills->toArray()[0]->created_at }}").fromNow())
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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