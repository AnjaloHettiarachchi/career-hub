@extends('layouts.main')

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/opportunity.show.css') }}">
@endsection

@section('content')
    <div id="container" class="ui raised segment">
        <div class="ui container">
            <h1>
                <a onclick="window.history.back()" href="#">
                    <i class="left arrow circular blue inverted small icon" ></i>
                </a>
                {{ $op_details->op_title }}
            </h1>
            <span class="meta">
                Opportunity by
                <a class="ui image blue image label" href="/">
                    <img class="ui right spaced avatar image" src="data:image/png;base64,{{ chunk_split(base64_encode($com_details->com_avatar)) }}" alt="{{ $com_details->com_title }}">
                    <strong>{{ $com_details->com_title  }}</strong>
                    <div class="detail">
                        <script type="text/javascript">
                            document.write(moment("{{ $op_details->created_at }}").format('MMMM Do YYYY, h:mm A'))
                        </script>
                    </div>
                </a>
            </span>
            <br><br>
            <p>{!! nl2br($op_details->op_desc) !!}</p>
        </div>
    </div>
@endsection