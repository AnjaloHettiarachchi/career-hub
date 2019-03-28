$(document).ready(function () {
    let hasSkills = false;
    let skill_registry = [];
    let skills =[];

    $('#image').change(function () {
        readURL(this);
    });

    $('#title').on('change keyup paste', function () {
        validator($(this).val(), $('#desc').val(), hasSkills);
    });

    $('#desc').on('change keyup paste', function () {
        validator($(this).val(), $('#title').val(), hasSkills);
    });

    $('#tab-set .item').tab();

    $.ajax({
        url: '/skills',
        method: 'GET'
    }).done((res) => {
        $('.ui.search')
            .search({
                type: 'category',
                source: res,
                searchFields: ['title'],
                transition: 'slide down',
                onSelect: function (result) {
                    hasSkills = true;

                    //Validation
                    validator($('#title').val(), $('#desc').val(), hasSkills);

                    if (skill_registry.length !== 0 && $.inArray(result['skill_id'], skill_registry) !== -1) {
                        alert(result['title'] + ' is already defined in the skill list.');
                    } else {
                        createNewSkillEntry(skills, result);
                        skill_registry.push(result['skill_id']);
                    }

                    $('#skills').val(skills);
                }
            });
    });

});

function validator(title, desc, hasSkills) {
    if(title !== "" && desc !== "" && hasSkills) {
        $("#submit").removeClass('disabled');
    } else {
        $("#submit").addClass('disabled');
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function createNewSkillEntry(skills_array, new_skill) {

    if (skills_array.length === 0) {
        $('#skill-list')
            .removeClass('placeholder')
            .html(`
                    <div id="skill-list-div" class="ui relaxed divided selection list">
                      <div id="skill-` + new_skill['skill_id'] + `" class="skill item">
                        <i class="large star middle aligned yellow icon"></i>
                        <div class="content">
                          <span class="ui big header">` + new_skill['title'] + `</span>
                          <div class="description">` + new_skill['category'] + `</div>
                        </div>
                      </div>
                    </div>
                `)
    } else {
        $('#skill-list-div')
            .append(`
                    <div id="skill-` + new_skill['skill_id'] + `" class="skill item">
                        <i class="large star middle aligned yellow icon"></i>
                        <div class="content">
                          <span class="ui big header">` + new_skill['title'] + `</span>
                          <div class="description">` + new_skill['category'] + `</div>
                        </div>
                    </div>
                `)
    }

    skills_array.push(new_skill['skill_id']);

}