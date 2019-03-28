<div id="settings-content" class="ui content-div segment">
    <h1>Settings</h1>

    <div class="ui styled fluid accordion">
        <div class="ui big title header">
            <i class="building icon"></i>
            Company Settings
        </div>
        <div class="content">

            <form class="ui form" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="ui grid">
                    <div class="ui two wide column">
                        <img id="avatar-preview" class="ui fluid circular image"
                             src="data:image/png;base64,{{ chunk_split(base64_encode($com_details->com_avatar)) }}"
                             alt="avatar">
                    </div>
                    <div class="ui six wide middle aligned column">
                        <div class="field {{ $errors->has('avatar') ? 'error' : '' }}">
                            <label for="avatar">Company Avatar</label>
                            <input type="file" name="avatar" id="avatar" accept="[image/jpeg][image/png]">
                        </div>
                    </div>
                </div>
                <br>
                <script type="text/javascript">
                    $(document).ready(() => {
                        $('#aoe').dropdown('set selected', {{ $com_details->aoe_id }})
                    })
                </script>
                <div class="input field {{ $errors->has('aoe') ? 'error' : '' }}">
                    <label for="aoe">Area of Expertise</label>
                    <select class="ui dropdown" id="aoe" name="aoe">
                        <option value="">Select your Company's Area of Expertise</option>
                        @foreach($aoe_list as $aoe)
                            <option value="{{ $aoe->aoe_id }}">{{ $aoe->aoe_name }}</option>
                        @endforeach
                        <option value="0">Other</option>
                    </select>
                </div>

                <div class="input field {{ $errors->has('title') ? 'error' : '' }}">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="Example Company PLC"
                           value="{{ $com_details->com_title }}">
                </div>

                <div class="input field {{ $errors->has('desc') ? 'error' : '' }}">
                    <label for="desc">Description</label>
                    <textarea name="desc" id="desc" placeholder="Provide a short description about your company..."
                              rows="3">{{ $com_details->com_desc }}</textarea>
                </div>

                <div class="input field {{ $errors->has('address') ? 'error' : '' }}">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" placeholder="No.01&#x0a;Example Lane&#x0a;Example City"
                              rows="3">{{ $com_details->com_address }}</textarea>
                </div>

                <button class="ui labeled icon green button">
                    <i class="far fa-building icon"></i> Save Company Details
                </button>

            </form>

        </div>
        <div class="ui big title header">
            <i class="user icon"></i>
            Account Settings
        </div>
        <div class="content">
            <div class="ui red left icon labeled big button">
                <i class="trash icon"></i> Delete Account
            </div>
        </div>
    </div>

</div>