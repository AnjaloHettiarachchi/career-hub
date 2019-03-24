@extends('layouts.main')

@section('js')
    <script src="{{ asset('js/opportunity.create.js') }}"></script>
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

        <form action="{{ route('opportunities.store') }}" class="ui form" method="POST" enctype="multipart/form-data">

            <input name="skills" type="hidden" id="skills"/>
            {{ csrf_field() }}

            <div class="ui two column stackable grid">

                <div class="center aligned column">
                    <div class="field">
                        <label for="banner">Banner Image</label>
                        <div class="ui rounded image">
                            {{-- Dimmer Start --}}
                            <div class="ui dimmer">
                                <div class="content">
                                    <button class="ui big positive button" id="upload">
                                        <i class="cloud upload icon"></i>Upload a Banner Image
                                    </button>
                                </div>
                            </div>
                            {{-- Dimmer End --}}
                            <img class="ui rounded image" name="banner-img" id="banner-img"
                                 src="{{ asset('png/poster.jpg') }}"
                                 alt="poster">
                        </div>
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
                            <textarea id="desc" name="desc" rows="24" placeholder="Description about the opportunity..."></textarea>
                        </div>
                    </div>
                    <div class="ui bottom attached tab segment" data-tab="second">
                        <div class="ui top attached segment">
                            <div class="ui info icon message">
                                <i class="info circle icon"></i>
                                <div class="content">
                                    <p>
                                        You can define relevant skills and their specific competence levels for
                                        your opportunity below. You can search for skills and can define competence
                                        levels after adding them to the list.
                                    </p>
                                </div>
                            </div>
                            <div class="ui fluid search">
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

            <button id="submit" name="submit" type="submit" class="ui right floated disabled positive button">
                Create Opportunity
            </button>

        </form>

    </div>
@endsection