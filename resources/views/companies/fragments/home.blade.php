<div id="home-content" class="ui content-div segment">
    <h1>Home</h1>

    @if (count($com_ops) > 0)
        <div class="ui dividing header">Recent Opportunities</div>
        <div class="ui feed">
        @foreach ($com_ops as $op)

                <div class="event">
                    <div class="label">
                        <i class="users circular inverted blue icon"></i>
                    </div>
                    <div class="content">
                        <div class="summary">
                            You created an opportunity as <a href="{{ route('opportunities.show', $op->op_id) }}">{{ $op->op_title }}</a>.
                            <div class="date">
                                <script type="text/javascript">
                                    document.write(moment("{{ $op->created_at }}").fromNow())
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

        @endforeach
        </div>

    @else

        <div class="ui placeholder center aligned segment">
            <div class="ui icon header">
                <i class="users icon"></i>
                No recent activities yet.
            </div>
            <p>An opportunity can be used to inform the students with possible recruitment or training positions of your company.</p>
            <a class="ui primary button" href="{{ route('opportunities.create') }}">Create a New Opportunity</a>
        </div>

    @endif

</div>