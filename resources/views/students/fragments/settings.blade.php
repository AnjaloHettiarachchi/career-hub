<div id="settings-content" class="ui content-div segment">
    <h1>Settings</h1>

    <div class="ui styled fluid accordion">
        <div class="ui big title header">
            <i class="graduation hat icon"></i>
            Student Settings
        </div>
        <div class="content">

            <form class="ui form">

                {{ csrf_field() }}
                <input type="hidden" name="deg" id="deg">

                <script type="text/javascript">
                    $(document).ready(() => {
                        // $('.ui.search').search('set selected', 1)
                    })
                </script>

                <div class="ui grid">
                    <div class="ui three wide column">
                        <img id="avatar-preview" class="ui fluid circular image"
                             src="data:image/png;base64,{{ chunk_split(base64_encode($stu_details->stu_avatar)) }}"
                             alt="avatar">
                    </div>
                    <div class="ui six wide middle aligned column">
                        <div class="field {{ $errors->has('avatar') ? 'error' : '' }}">
                            <label for="avatar">Profile Avatar</label>
                            <input type="file" name="avatar" id="avatar" accept="[image/jpeg][image/png]"
                                   value="{{ old('avatar') }}">
                        </div>
                    </div>
                </div>
                <br>

                <div class="field" id="fac-field">
                    <label for="fac">Faculty</label>
                    <select name="fac" id="fac">
                        <option value="">Select your Faculty</option>
                        @foreach ($fac_list as $fac)
                            <option value="{{ $fac->fac_id }}">{{ $fac->fac_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field" id="uni-field">
                    <label for="uni">University</label>
                    <select name="uni" id="uni">
                        <option value="">Select your University</option>
                        @foreach ($uni_list as $uni)
                            <option value="{{ $uni->uni_id }}">{{ $uni->uni_title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field {{ $errors->has('deg') ? 'error' : '' }}">
                    <label for="deg">Degree Program</label>
                    <div class="ui category fluid search">
                        <div class="ui icon input">
                            <input class="prompt" type="text" placeholder="Search for your Degree Program"
                                   value="{{ $stu_details->deg_title }}">
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
                    </div>
                </div>

                <div class="field {{ $errors->has('sit') ? 'error' : '' }}">
                    <label for="sit">ID Card Type</label>
                    <select name="sit" id="sit">
                        <option value="">Select your Student ID Card Type</option>
                        @foreach ($sit_list as $sit)
                            <option value="{{ $sit->sit_id }}">{{ $sit->sit_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field {{ $errors->has('stu_prov_id') ? 'error' : '' }}" id="prov-id-field">
                    <label for="stu_prov_id">ID Card No.</label>
                    <div class="ui input">
                        <input type="text" placeholder="Student ID No." name="stu_prov_id" id="stu_prov_id"
                               value="{{ $stu_details->stu_prov_id }}">
                    </div>
                </div>

                <div class="field {{ $errors->has('full_name') ? 'error' : '' }}">
                    <label for="full_name">Full Name</label>
                    <div class="ui input">
                        <input type="text" placeholder="Student Full Name" name="full_name" id="full_name"
                               value="{{ $stu_details->stu_full_name }}">
                    </div>
                </div>

                <div class="field {{ $errors->has('bio') ? 'error' : '' }}">
                    <label for="bio">Biography</label>
                    <div class="ui input">
                        <textarea type="text" placeholder="A small summary about yourself..." name="bio"
                                  id="bio">{{ $stu_details->stu_bio }}</textarea>
                    </div>
                </div>

                <div class="field {{ $errors->has('con_num') ? 'error' : '' }}">
                    <label for="con_num">Contact No.</label>
                    <div class="ui input">
                        <input type="text" placeholder="Student Contact No." name="con_num" id="con_num"
                               value="{{ $stu_details->stu_con_num }}">
                    </div>
                </div>

                <div class="field {{ $errors->has('stu_email') ? 'error' : '' }}">
                    <label for="stu_email">Email Address</label>
                    <div class="ui input">
                        <input type="email" placeholder="Student Email Address" name="stu_email" id="stu_email"
                               value="{{ $stu_details->stu_email }}">
                    </div>
                </div>

                <button type="button" class="ui green left icon labeled disabled button">
                    <i class="save icon"></i> Save Student Details
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