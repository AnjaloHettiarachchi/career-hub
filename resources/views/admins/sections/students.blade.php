@extends('layouts.main')

@section('nav')

    <a class="item" style="background-color: #BD2828" href="{{ route('admins.logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <h4><i class="sign-out icon"></i>LOGOUT</h4>
    </a>
    <form id="logout-form" action="{{ route('admins.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            let table = $('#table').DataTable({
                'responsive': true,
                'columnDefs': [
                    {
                        'targets': [1, 4, 5, 6, 10, 11],
                        'visible': false,
                    }
                ]
            });

            $('#table tbody tr').on('click', function () {
                let row = table.row($(this));

                if (row.child.isShown()) {
                    row.child.hide();
                    $(this).removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    $(this).addClass('shown');
                }
            })

        });

        function format(data) {
            return '<table class="ui inverted blue table">' +
                '<tr>' +
                '<td class="two wide"><b>Avatar:</b></td>' +
                '<td>' + data[1] + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Biography:</b></td>' +
                '<td>' + data[4] + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Contact No.:</b></td>' +
                '<td>' + data[5] + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Email Address:</b></td>' +
                '<td>' + data[6] + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Joined on:</b></td>' +
                '<td>' + data[10] + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Account last updated on:</b></td>' +
                '<td>' + data[11] + '</td>' +
                '</tr>' +
                '</table>';
        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.sections.students.index.css') }}">
@endsection

@section('content')

    <div id="container" class="ui raised inverted clearing segment">
        <h1>
            <a href="#">
                <i class="left arrow icon" onclick="window.history.back()"></i>
            </a> {{ env('APP_NAME') }}<i class="angle right icon"></i>Student Accounts
        </h1>
        <p><strong>Note:</strong> Click on a record to view more details.</p>
        <br>
        <table id="table" class="ui selectable inverted blue celled table">
            <thead>
            <tr>
                <th>ID</th>
                <th class="none">Avatar</th>
                <th>Student ID</th>
                <th>Full Name</th>
                <th class="none">Student Bio.</th>
                <th class="none">Contact No.</th>
                <th class="none">Email Address</th>
                <th>Faculty</th>
                <th>Degree Program</th>
                <th>University</th>
                <th class="none">Joined on</th>
                <th class="none">Account Last Updated on</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stu_list as $key => $value)
                <tr>
                    <td>{{ $value->stu_id }}</td>
                    <td>
                        <img src="data:image/png;base64,{{ chunk_split(base64_encode($value->stu_avatar)) }}" class="ui rounded small image" alt="stu_avatar">
                    </td>
                    <td>({{ $value->sit_name }}) {{ $value->stu_prov_id }}</td>
                    <td>{{ $value->stu_full_name }}</td>
                    <td>{{ $value->stu_bio }}</td>
                    <td>{{ $value->stu_con_num }}</td>
                    <td>{{ $value->stu_email }}</td>
                    <td>{{ $value->fac_short_name }}</td>
                    <td>{{ $value->deg_title }}</td>
                    <td>{{ $value->uni_title }}</td>
                    <td>
                        {{ Carbon\Carbon::createFromTimeString($value->joined_on)->format("d-m-Y h:i A") }}
                    </td>
                    <td>
                        {{ Carbon\Carbon::createFromTimeString($value->updated_on)->format("d-m-Y h:i A") }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection