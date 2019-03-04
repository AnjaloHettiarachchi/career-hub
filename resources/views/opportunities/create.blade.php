@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/opportunity.create.css') }}">
@endsection

@section('content')
    <div id="container" class="ui clearing raised segment">
        <div class="ui blue massive ribbon label">{{ $com_title }}</div>
        <h1>Opportunity<i class="angle right icon"></i>Create</h1>

        <form action="{{ route('opportunities.store') }}" class="ui form" method="POST">

            <div class="ui two column stackable grid">

                <div class="center aligned column">
                    <img src="{{ asset('png/img_avatar.png') }}" alt="">
                    <input type="file" name="banner" id="banner" hidden>
                </div>

                <div class="column">
                    <div class="field">
                        <label for="">Opportunity Title</label>
                        <input type="text" name="title" id="title" placeholder="i.e. ">
                    </div>
                    <div class="field">
                        <label for="">Opportunity Title</label>
                        <input type="text" name="title" id="title" placeholder="i.e. ">
                    </div>
                    <div class="field">
                        <label for="">Opportunity Title</label>
                        <input type="text" name="title" id="title" placeholder="i.e. ">
                    </div>
                </div>

            </div>

        </form>

    </div>
@endsection