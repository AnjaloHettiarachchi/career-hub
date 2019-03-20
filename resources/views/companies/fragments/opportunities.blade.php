<div id="op-content" class="ui content-div segment">
    <h1>Opportunities</h1>

    @if (count($com_ops) > 0)
        <div class="ui raised four link stackable cards">
            @foreach ($com_ops as $op)

                <a class="ui card" href="{{ route('opportunities.show', $op->op_id) }}">
                    <div class="image">
                        <img src="{{ asset('png/poster.jpg') }}" alt="banner">
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
                    </div>
                </a>

            @endforeach

                <a class="ui blue card" href="{{ route('opportunities.create') }}">
                    <div class="content">
                        <div class="ui huge header">Create<br>A New<br>Opportunity</div>
                    </div>
                </a>

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