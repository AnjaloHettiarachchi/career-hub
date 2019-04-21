<div id="find-content" class="ui content-div segment">

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#table1').DataTable();
        });

    </script>

    <h1>Find Opportunities</h1>
    <p>We found and ranked following opportunities as most suitable for you based on the skills you have mentioned in
        <b>Skills & Achievements</b>.
    </p>

    <div class="ui inverted blue segment">

        <table id="table1" class="ui selectable inverted blue table">
            <thead>
            <tr>
                <th>No.</th>
                <th>Company</th>
                <th>Opportunity</th>
            </tr>
            </thead>
            <tbody>

            @foreach($op_list as $ops)
                @php $num = $loop->iteration @endphp
                @foreach($ops as $op)
                    <tr onclick="window.location.href='{{ route('opportunities.show', $op->op_id) }}'">
                        <td class="center aligned one wide">
                            <h1>{{ $num }}</h1>
                        </td>
                        <td class="one wide">
                            <img class="ui rounded image"
                                 src="data:image/png;base64,{{ chunk_split(base64_encode($op->com_avatar)) }}"
                                 alt="com_avatar">
                        </td>
                        <td>
                            <h1>{{ $op->op_title }}</h1>
                            <i class="building icon"></i> By <b>{{ $op->com_title }}</b>
                            <i class="history icon" style="margin-left: 5em"></i>
                            <script type="text/javascript">
                                document.write("Created " + moment("{{ $op->created_at }}").fromNow() + "<br>")
                            </script>
                        </td>
                    </tr>
                @endforeach
            @endforeach

            </tbody>
        </table>

    </div>

</div>