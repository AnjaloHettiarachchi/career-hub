<div id="con-content" class="ui content-div basic segment">

    <script type="text/javascript" src="{{ asset('js/conversations.js') }}"></script>

    {{ csrf_field() }}

    {{-- Modal --}}
    <div class="ui modal">
        <div class="header">New Conversation</div>
        <div class="scrolling content">
            <div class="ui relaxed divided selection list">

                @foreach($stu_list as $stu)

                    <div class="item"
                         onclick="startConversation(this, 'c2s', {{ $com_details->com_id }}, {{ $stu->stu_id }})">
                        <img class="ui avatar image"
                             src="data:image/png;base64,{{ chunk_split(base64_encode($stu->stu_avatar)) }}"
                             alt="{{ $stu->stu_full_name }}">
                        <div class="content">
                            <div class="ui large header">{{ $stu->stu_full_name }}</div>
                            <div class="description">Online</div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
        <div class="actions">
            <div class="ui cancel button">Cancel</div>
        </div>
    </div>

    <div id="chat-container" class="ui grid">

        <div class="ui six wide column">
            <div class="ui segment">
                <div class="ui huge header">Conversations</div>
                <div id="chat-list" class="ui relaxed divided selection list">
                    @if (count($com_con_list) > 0)

                        @foreach ($com_con_list as $con)

                            <div class="item" onclick="resumeConversation(this, 'c2s',{{ $con->com_id }}, {{ $con->stu_id }})">
                                <img class="ui avatar image" src="data:image/png;base64,{{ chunk_split(base64_encode($con->stu_avatar)) }}" alt="header-avatar">
                                <div class="content">
                                    <div class="ui header">{{ $con->stu_full_name }}</div>
                                    <div class="description">Online</div>
                                </div>
                            </div>

                        @endforeach

                    @else
                        No conversations yet.
                    @endif
                </div>
            </div>
        </div>

        <div class="ui ten wide column">
            <div id="chat-header" class="ui top attached segment"></div>
            <div id="chat-room" class="ui placeholder center aligned middle attached segment">
                @if (count($com_con_list) == 0)

                    <div class="ui icon header">
                        <i class="comments icon"></i>
                        There are no any conversations to show yet.
                    </div>
                    <p>An opportunity can be used to inform the students with possible recruitment or training positions of
                        your company.</p>
                    <div id="new" class="ui primary button">Start a New Conversation</div>

                @else

                    <p>Click on a contact to resume that Conversation.</p>

                @endif
            </div>
            <div id="chat-send" class="ui bottom attached segment">
                <div class="ui fluid form">
                    <div class="ui inline fields">
                        <div class="fifteen wide field">
                            <input type="text" id="message" name="message" placeholder="Type your message here...">
                        </div>
                        <div class="field">
                            <button id="send-button" class="ui green icon button">
                                <i class="send icon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>