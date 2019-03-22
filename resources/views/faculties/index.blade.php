@extends('layouts.main')

@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable();

            $('#name, #full-name').on('change keyup paste', function () {
                if (validate()) {
                    $('#save').removeClass('disabled')
                } else {
                    $('#save').addClass('disabled')
                }
            });

            $('#edit-name, #edit-full-name').on('change keyup paste', function () {
                if (validate_edit()) {
                    $('#update').removeClass('disabled')
                } else {
                    $('#update').addClass('disabled')
                }
            });

            $('#add-button').on('click', function () {
                $('#add-modal')
                    .modal({
                        onApprove: function (e) {
                            let name = $('#name').val();
                            let full = $('#full-name').val();

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                },
                                url: '{{ route('faculties.store') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {name: name, full: full},
                                success: function () {
                                    window.location.reload();
                                },
                                error: function (error) {
                                    alert('Data not saved. ' + error.responseJSON.errors.length[0]);
                                }
                            })

                        }
                    })
                    .modal('show')
            })

        });

        function validate() {
            return $('#name').val() !== '' && $('#full-name').val() !== '';
        }

        function validate_edit() {
            return $('#edit-name').val() !== '' && $('#edit-full-name').val() !== '';
        }

        function showEdit(ele) {
            $("#edit-name").val($(ele).find('.fac-name').text());
            $("#edit-full-name").val($(ele).find('.fac-full-name').text());

            $('#edit-modal')
                .modal({
                    onApprove: function (e) {
                        let name = $("#edit-name").val();
                        let full = $("#edit-full-name").val();

                        if ($(e).hasClass('red')) {
                            if (confirm('Do you really want to remove the ' + $(ele).find('.fac-full-name').text() + ' faculty?')) {

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                    },
                                    url: 'faculties/' + $(ele).find('.fac-id').text(),
                                    method: 'DELETE',
                                    success: function () {
                                        window.location.reload();
                                    },
                                    error: function (error) {
                                        alert('Record not deleted. ' + error.responseJSON.errors.length[0]);
                                    }
                                })

                            }
                        } else {

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                },
                                url: 'faculties/' + $(ele).find('.fac-id').text(),
                                method: 'PUT',
                                data: {name: name, full: full},
                                success: function () {
                                    window.location.reload();
                                },
                                error: function (error) {
                                    alert('Record not updated. ' + error.responseJSON.errors.length[0]);
                                }
                            })

                        }
                    }
                })
                .modal('show');
        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
    <link rel="stylesheet" href="{{ asset('css/faculties.index.css') }}">
@endsection

@section('content')

    <div id="container" class="ui raised inverted clearing segment">
        <h1>
            <a href="#">
                <i class="left arrow icon" onclick="window.history.back()"></i>
            </a> {{ env('APP_NAME') }}<i class="angle right icon"></i>Faculties
        </h1>
        <p><strong>Note:</strong> Click on a record to update or remove.</p>
        <br>
        <table id="table" class="ui selectable inverted blue celled table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Short Name</th>
                <th>Full Name</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fac_list as $key => $value)
                <tr onclick="showEdit(this)">
                    <td class="fac-id">{{ $value->fac_id }}</td>
                    <td class="fac-name">{{ $value->fac_short_name }}</td>
                    <td class="fac-full-name">{{ $value->fac_name }}</td>
                    <td>
                        <script type="text/javascript">
                            document.write(moment("{{ $value->created_at }}").format("DD-MM-YYYY h:mm A"))
                        </script>
                    </td>
                    <td>
                        <script type="text/javascript">
                            document.write(moment("{{ $value->updated_at }}").format("DD-MM-YYYY h:mm A"))
                        </script>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br>
        <button class="ui positive right floated labeled icon button" id="add-button"><i class="plus icon"></i>
            Add New Faculty
        </button>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="ui modal">
        <div class="header">
            Faculty<i class="angle right icon"></i>Edit
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="name">Faculty Short Name</label>
                    <div class="ui left icon input">
                        <i class="hashtag icon"></i>
                        <input type="text" placeholder="i.e. SOC" name="edit-name" id="edit-name">
                    </div>
                </div>

                <div class="field">
                    <label for="length">Faculty Full Name</label>
                    <div class="ui left icon input">
                        <i class="building icon"></i>
                        <input type="text" placeholder="i.e. School of Computing" name="full-name" id="edit-full-name">
                    </div>
                </div>

            </form>

        </div>
        <div class="actions">
            <button class="ui positive labeled icon disabled button" id="update"><i class="save icon"></i>Update</button>
            <button class="ui approve red labeled icon button" id="remove"><i class="trash icon"></i>Remove</button>
            <button class="ui deny labeled icon button" id="cancel"><i class="times icon"></i>Cancel</button>
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="add-modal" class="ui modal">
        <div class="header">
            Faculty<i class="angle right icon"></i>New
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="name">Faculty Short Name</label>
                    <div class="ui left icon input">
                        <i class="hashtag icon"></i>
                        <input type="text" placeholder="i.e. SOC" name="name" id="name">
                    </div>
                </div>

                <div class="field">
                    <label for="length">Faculty Full Name</label>
                    <div class="ui left icon input">
                        <i class="building icon"></i>
                        <input type="text" placeholder="i.e. School of Computing" name="full-name" id="full-name">
                    </div>
                </div>

            </form>

        </div>
        <div class="actions">
            <button class="ui positive labeled icon disabled button" id="save"><i class="save icon"></i> Save</button>
            <button class="ui deny labeled icon button" id="cancel"><i class="times icon"></i> Cancel</button>
        </div>
    </div>

@endsection