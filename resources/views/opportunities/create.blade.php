@extends('layouts.main')

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            ClassicEditor
                .create(document.querySelector('#desc'))
                .catch(error => {
                    console.error(error);
                })
            $('#tab-set .item').tab();
        })
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/opportunity.create.css') }}">
@endsection

@section('content')
    <div id="container" class="ui clearing raised segment">
        <div class="ui blue massive ribbon label">
            <span>Opportunity from</span>
            <br>{{ $com_title }}</div>
        <h1>Opportunity<i class="angle right icon"></i>Create</h1>

        <form action="{{ route('opportunities.store') }}" class="ui form" method="POST">

            <div class="ui two column stackable grid">

                <div class="center aligned column">
                    <div class="field">
                        <label for="banner">Click to upload a banner image</label>
                        <img class="ui rounded image" name="banner" id="banner" src="{{ asset('png/poster.jpg') }}"
                             alt="poster">
                        <input type="file" name="banner" id="banner" hidden>
                    </div>
                </div>

                <div class="ui column">
                    <div class="ui top attached tabular menu" id="tab-set">
                        <a class="item active" data-tab="first">Opportunity Content</a>
                        <a class="item" data-tab="second">Skills & Competence Levels</a>
                    </div>
                    <div class="ui bottom attached tab segment active" data-tab="first">
                        <div class="field">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" placeholder="i.e. IT Internships">
                        </div>
                        <div class="field">
                            <label for="desc">Description</label>
                            <textarea id="desc" name="desc"></textarea>
                        </div>
                    </div>
                    <div class="ui bottom attached tab segment" data-tab="second">
                        <div class="ui top attached segment">
                            <div class="ui search">
                                <div class="ui icon fluid input">
                                    <input class="prompt" type="text" placeholder="Search Skills...">
                                    <i class="search icon"></i>
                                </div>
                                <div class="results"></div>
                            </div>
                        </div>
                        <div id="skill-list" class="ui middle attached placeholder segment">
                            <div class="ui icon header">
                                <i class="orange exclamation triangle icon"></i>
                                No Skills are yet listed for this opportunity.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <button type="submit" class="ui right floated disabled positive button">Create Opportunity</button>

        </form>

    </div>
@endsection