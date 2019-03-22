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

            $('#short-code, #title').on('change keyup paste', function () {
                if (validate()) {
                    $('#save').removeClass('disabled')
                } else {
                    $('#save').addClass('disabled')
                }
            });

            $('#edit-short-code, #edit-title').on('change keyup paste', function () {
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
                            let name = $('#short-code').val();
                            let full = $('#title').val();

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                },
                                url: '{{ route('universities.store') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {short: name, title: full},
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
            return $('#short-code').val() !== '' && $('#title').val() !== '';
        }

        function validate_edit() {
            return $('#edit-short-code').val() !== '' && $('#edit-title').val() !== '';
        }

        function showEdit(ele) {
            $("#edit-short-code").val($(ele).find('.uni-short-code').text());
            $("#edit-title").val($(ele).find('.uni-title').text());

            $('#edit-modal')
                .modal({
                    onApprove: function (e) {
                        let name = $("#edit-short-code").val();
                        let full = $("#edit-title").val();

                        if ($(e).hasClass('red')) {
                            if (confirm('Do you really want to remove the ' + $(ele).find('.uni-title').text() + '?')) {

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                    },
                                    url: 'universities/' + $(ele).find('.uni-id').text(),
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
                                url: 'universities/' + $(ele).find('.uni-id').text(),
                                method: 'PUT',
                                data: {short: name, title: full},
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
    <link rel="stylesheet" href="{{ asset('css/universities.index.css') }}">
@endsection

@section('content')

    <div id="container" class="ui raised inverted clearing segment">
        <h1>
            <a href="#">
                <i class="left arrow icon" onclick="window.history.back()"></i>
            </a> {{ env('APP_NAME') }}<i class="angle right icon"></i>Universities
        </h1>
        <p><strong>Note:</strong> Click on a record to update or remove.</p>
        <br>
        <table id="table" class="ui selectable inverted blue celled table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Short Code</th>
                <th>Title</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
            </thead>
            <tbody>
            @foreach($uni_list as $key => $value)
                <tr onclick="showEdit(this)">
                    <td class="uni-id">{{ $value->uni_id }}</td>
                    <td class="uni-short-code">{{ $value->uni_short_code }}</td>
                    <td class="uni-title">{{ $value->uni_title }}</td>
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
            Add New University
        </button>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="ui modal">
        <div class="header">
            University<i class="angle right icon"></i>Edit
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="name">University Short Code</label>
                    <div class="ui left icon input">
                        <i class="hashtag icon"></i>
                        <input type="text" placeholder="i.e. PLY" name="edit-short-code" id="edit-short-code">
                    </div>
                </div>

                <div class="field">
                    <label for="length">University Title</label>
                    <div class="ui left icon input">
                        <i class="university icon"></i>
                        <input type="text" placeholder="i.e. Plymouth University, United Kingdom" name="edit-title" id="edit-title">
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
            University<i class="angle right icon"></i>New
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="name">University Short Code</label>
                    <div class="ui left icon input">
                        <i class="hashtag icon"></i>
                        <input type="text" placeholder="i.e. PLY" name="short-code" id="short-code">
                    </div>
                </div>

                <div class="field">
                    <label for="length">University Title</label>
                    <div class="ui left icon input">
                        <i class="university icon"></i>
                        <input type="text" placeholder="i.e. Plymouth University, United Kingdom" name="title" id="title">
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