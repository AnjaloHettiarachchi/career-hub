<div id="op-content" class="ui content-div segment">
    <h1>Opportunities</h1>

    @if (count($com_ops) > 0)
        <div class="ui raised four link cards">
            @foreach ($com_ops as $op)

                <div class="ui card">
                    <div class="image">
                        <img src="{{ asset('png/poster.jpg') }}">
                    </div>
                    <div class="content">
                        <div class="header">{{ $op->op_title }}</div>
                        <div class="meta">
                            <span class="date">
                                <script type="text/javascript">
                                    document.write("Created " + moment("{{ $op->created_at }}").fromNow())
                                </script>
                            </span>
                        </div>
                        <div class="description">
                            <p style="text-overflow: ellipsis">{{ $op->op_desc }}</p>
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
            <p>An opportunity can be used to inform the students with possible recruitment or training positions of your
                company.</p>
            <a class="ui primary button" href="{{ route('opportunities.create') }}">Create a New Opportunity</a>
        </div>

    @endif

</div>