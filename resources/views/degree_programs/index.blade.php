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
            $('#fac, #uni, #edit-fac, #edit-uni').dropdown();

            $('#fac, #uni, #title').on('change keyup paste', function () {
                if (validate()) {
                    $('#save').removeClass('disabled')
                } else {
                    $('#save').addClass('disabled')
                }
            });

            $('#edit-fac, #edit-uni, #edit-title').on('change keyup paste', function () {
                if (validate_edit()) {
                    $('#update').removeClass('disabled')
                } else {
                    $('#update').addClass('disabled')
                }
            });

            $('#add-button').on('click', function () {
                $('#add-modal')
                    .modal({
                        autofocus: false,
                        onApprove: function (e) {
                            let fac = $('#fac option:selected').val();
                            let uni = $('#uni option:selected').val();
                            let title = $('#title').val();

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                },
                                url: '{{ route('degreePrograms.store') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {fac: fac, uni: uni, title: title},
                                success: function () {
                                    window.location.reload();
                                },
                                error: function (error) {
                                    alert('Data not saved. ' + error.responseJSON.errors.length[0]);
                                }
                            })

                        }
                    })
                    .modal('show');
            })

        });

        function validate() {
            return $('#fac option:selected').val() !== '' && $('#uni option:selected').val() !== '' && $('#title').val() !== '';
        }

        function validate_edit() {
            return $('#edit-fac option:selected').val() !== '' && $('#edit-uni option:selected').val() !== '' && $('#edit-title').val() !== '';
        }

        function showEdit(ele) {
            $("#edit-fac").dropdown(
                'set selected', $(ele).find('.deg-fac').data('id')
            );
            $("#edit-uni").dropdown(
                'set selected', $(ele).find('.deg-uni').data('id')
            );
            $("#edit-title").val($(ele).find('.deg-title').text());

            $('#edit-modal')
                .modal({
                    autofocus: false,
                    onApprove: function (e) {
                        let fac = $('#edit-fac option:selected').val();
                        let uni = $('#edit-uni option:selected').val();
                        let title = $('#edit-title').val();

                        if ($(e).hasClass('red')) {
                            if (confirm('Do you really want to remove the ' + $(ele).find('.uni-title').text() + '?')) {

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                                    },
                                    url: 'degreePrograms/' + $(ele).find('.deg-id').text(),
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
                                url: 'degreePrograms/' + $(ele).find('.deg-id').text(),
                                method: 'PUT',
                                data: {fac: fac, uni: uni, title: title},
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
            </a> {{ env('APP_NAME') }}<i class="angle right icon"></i>Degree Programs
        </h1>
        <p><strong>Note:</strong> Click on a record to update or remove.</p>
        <br>
        <table id="table" class="ui selectable inverted blue celled compact table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Faculty</th>
                <th>University</th>
                <th>Title</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deg_list as $key => $value)
                <tr onclick="showEdit(this)">
                    <td class="deg-id">{{ $value->deg_id }}</td>
                    <td class="deg-fac" data-id="{{ $value->fac_id }}">{{ $fac_list->where('fac_id', $value->fac_id)->pluck('fac_short_name')->first() }}</td>
                    <td class="deg-uni" data-id="{{ $value->uni_id }}">{{ $uni_list->where('uni_id', $value->uni_id)->pluck('uni_title')->first() }}</td>
                    <td class="deg-title">{{ $value->deg_title }}</td>
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
            Add New Degree Program
        </button>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="ui modal">
        <div class="header">
            Degree Program<i class="angle right icon"></i>Edit
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="edit-fac">Faculty</label>
                    <select name="edit-fac" id="edit-fac">
                        <option value="">Select Degree Program's Faculty</option>
                        @foreach ($fac_list as $fac)
                            <option value="{{ $fac->fac_id }}">{{ $fac->fac_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="edit-uni">University</label>
                    <select name="edit-uni" id="edit-uni">
                        <option value="">Select Degree Program's University</option>
                        @foreach ($uni_list as $uni)
                            <option value="{{ $uni->uni_id }}">{{ $uni->uni_title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="length">Degree Program Title</label>
                    <div class="ui left icon input">
                        <i class="graduation cap icon"></i>
                        <input type="text" placeholder="i.e. BSc. (Hons.) Software Engineering" name="edit-title"
                               id="edit-title">
                    </div>
                </div>

            </form>

        </div>
        <div class="actions">
            <button class="ui positive labeled icon disabled button" id="update"><i class="save icon"></i>Update
            </button>
            <button class="ui approve red labeled icon button" id="remove"><i class="trash icon"></i>Remove</button>
            <button class="ui deny labeled icon button" id="cancel"><i class="times icon"></i>Cancel</button>
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="add-modal" class="ui modal">
        <div class="header">
            Degree Program<i class="angle right icon"></i>New
        </div>
        <div class="description">

            <form class="ui form">

                {{ csrf_field() }}

                <div class="field">
                    <label for="fac">Faculty</label>
                    <select name="fac" id="fac">
                        <option value="">Select Degree Program's Faculty</option>
                        @foreach ($fac_list as $fac)
                            <option value="{{ $fac->fac_id }}">{{ $fac->fac_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="uni">University</label>
                    <select name="uni" id="uni">
                        <option value="">Select Degree Program's University</option>
                        @foreach ($uni_list as $uni)
                            <option value="{{ $uni->uni_id }}">{{ $uni->uni_title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="length">Degree Program Title</label>
                    <div class="ui left icon input">
                        <i class="graduation cap icon"></i>
                        <input type="text" placeholder="i.e. BSc. (Hons.) Software Engineering" name="title" id="title">
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