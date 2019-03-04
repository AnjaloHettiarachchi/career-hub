<div id="op-content" class="ui content-div segment">
    <h1>Opportunities</h1>

    @if ($op_count == 0)

        <div class="ui placeholder center aligned segment">
            <div class="ui icon header">
                <i class="users icon"></i>
                There are no opportunities listed yet.
            </div>
            <p>An opportunity can be used to inform the students with possible recruitment or training positions of your company.</p>
            <a class="ui primary button" href="{{ route('opportunities.create') }}">Create a New Opportunity</a>
        </div>

    @endif

</div>