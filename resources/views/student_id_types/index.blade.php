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

            $('#name, #length').on('change keyup paste', function () {
                if (validate()) {
                    $('#save').removeClass('disabled')
                } else {
                    $('#save').addClass('disabled')
                }
            });

            $('#edit-name, #edit-length').on('change keyup paste', function () {
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
                            let length = $('#length').val();

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                },
                                url: '{{ route('stuIdTypes.store') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {name: name, length: length},
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
            return $('#name').val() !== '' && $('#length').val() !== '';
        }

        function validate_edit() {
            return $('#edit-name').val() !== '' && $('#edit-length').val() !== '';
        }

        function showEdit(ele) {
            $("#edit-name").val($(ele).find('.sit-name').text());
            $("#edit-length").val($(ele).find('.sit-length').text());
            $('#edit-modal')
                .modal({
                    onApprove: function (e) {
                        let name = $("#edit-name").val();
                        let length = $("#edit-length").val();

                        if ($(e).hasClass('red')) {
                            if (confirm('Do you really want to remove the ' + $(ele).find('.sit-name').text() + ' type?')) {

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                    },
                                    url: 'stuIdTypes/' + $(ele).find('.sit-id').text(),
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
                                url: 'stuIdTypes/' + $(ele).find('.sit-id').text(),
                                method: 'PUT',
                                data: {name: name, length: length},
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
    <link rel="stylesheet" href="{{ asset('css/student_id_types.index.css') }}">
@endsection

@section('content')

    <div id="container" class="ui raised inverted clearing segment">
        <h1>
            <a href="#">
                <i class="left arrow icon" onclick="window.history.back()"></i>
            </a> {{ env('APP_NAME') }}<i class="angle right icon"></i>Student ID Types
        </h1>
        <p><strong>Note:</strong> Click on a record to update or remove.</p>
        <br>
        <table id="table" class="ui selectable inverted blue celled table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Length</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sit_list as $key => $value)
                <tr onclick="showEdit(this)">
                    <td class="sit-id">{{ $value->sit_id }}</td>
                    <td class="sit-name">{{ $value->sit_name }}</td>
                    <td class="sit-length">{{ $value->sit_length }}</td>
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
            Add New Student ID Type
        </button>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="ui modal">
        <div class="header">
            Student ID Type<i class="angle right icon"></i>Edit
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="name">Student ID Type Name</label>
                    <div class="ui left icon input">
                        <i class="id card icon"></i>
                        <input type="text" placeholder="i.e. University ID" name="name" id="edit-name">
                    </div>
                </div>

                <div class="field">
                    <label for="length">Student ID Type Length</label>
                    <div class="ui left icon input">
                        <i class="hashtag icon"></i>
                        <input type="text" placeholder="i.e. 10" name="length" id="edit-length">
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
            Student ID Type<i class="angle right icon"></i>New
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="name">Student ID Type Name</label>
                    <div class="ui left icon input">
                        <i class="id card icon"></i>
                        <input type="text" placeholder="i.e. University ID" name="name" id="name">
                    </div>
                </div>

                <div class="field">
                    <label for="length">Student ID Type Length</label>
                    <div class="ui left icon input">
                        <i class="hashtag icon"></i>
                        <input type="text" placeholder="i.e. 10" name="length" id="length">
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