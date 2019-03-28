@extends('layouts.main')

@section('js')
    <script src="{{ asset('js/achievements.create.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/achievements.create.css') }}">
@endsection

@section('content')
    <div id="container" class="ui clearing raised segment">
        <div class="ui blue massive ribbon label">
            <span>Achievement by</span>
            <br>{{ $stu_full_name }}</div>
        <h1>Achievement<i class="angle right icon"></i>Create</h1>

        <form action="{{ route('achievements.store') }}" class="ui form" method="POST" enctype="multipart/form-data">

            <input name="skills" type="hidden" id="skills"/>
            {{ csrf_field() }}

            <div class="ui top attached tabular menu" id="tab-set">
                <a class="item active" data-tab="first">Content</a>
                <a class="item" data-tab="second">Skills</a>
            </div>
            <div class="ui bottom attached tab segment active" data-tab="first">

                <div class="field">
                    <div class="ui grid">
                        <div class="ui four wide column">
                            <img id="image-preview" class="ui fluid rounded image"
                                 src="{{ asset('png/ach_img_alt.jpg') }}"
                                 alt="Achievement Image">
                        </div>
                        <div class="ui six wide middle aligned column">
                            <div class="field {{ $errors->has('image') ? 'error' : '' }}">
                                <label for="image">Upload an image about your achievement (Optional)</label>
                                <input type="file" name="image" id="image" accept="[image/jpeg][image/png]"
                                       value="{{ old('image') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="Achievement Title">
                </div>

                <div class="field">
                    <label for="desc">Description</label>
                    <textarea id="desc" name="desc" rows="10" placeholder="A description about your achievement"></textarea>
                </div>

            </div>
            <div class="ui bottom attached tab segment" data-tab="second">

                <div class="ui top attached segment">
                    <div class="ui info icon message">
                        <i class="info circle icon"></i>
                        <div class="content">
                            <p>
                                You can define relevant skills of yours involved in this achievement below. You
                                    can search for skills and add them to the list.
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
                        No Skills are listed for this Achievement yet.
                    </div>
                </div>

            </div>

            <button type="submit" id="submit" name="submit" class="ui green left icon right floated labeled disabled button">
                <i class="plus icon"></i> Create Achievement
            </button>

        </form>

    </div>
@endsection