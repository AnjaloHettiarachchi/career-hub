$(document).ready(function () {

    let skills = [];
    let skill_registry = [];
    let hasSkills = false;

    // ClassicEditor
    //     .create(document.querySelector('#desc'))
    //     .catch(error => {
    //         console.error(error)
    //     });

    $('#tab-set .item').tab();

    $('.image').dimmer({
        on: 'hover'
    });

    $('#upload').on('click', (e) => {
        e.preventDefault();
        $('#banner').click();
    });

    $('#banner').change(function () {
        readURL(this);
    });

    $('#title').on('change keyup paste', function () {
        validator($(this).val(), $('#desc').val(), hasSkills);
    });

    $('#desc').on('change keyup paste', function () {
        validator($(this).val(), $('#title').val(), hasSkills);
    });

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
                    let level;
                    hasSkills = true;

                    validator($('#title').val(), $('#desc').val(), hasSkills);

                    if (skill_registry.length !== 0 && $.inArray(result['skill_id'], skill_registry) !== -1) {
                        alert(result['title'] + ' skill is already defined.');
                    } else {
                        while (true) {
                            level = prompt('Competence Level for ' + result['title'] +
                                '.\n(Input a integer between 1-5)\n1 - Basic\n2 - Novice\n3 - Intermediate\n4 - Advance\n5 - Expert');
                            if (parseInt(level) > 0 && parseInt(level) < 6) {
                                break;
                            }
                        }
                        createNewSkillEntry(skills, result, level);
                        skill_registry.push(result['skill_id']);
                    }

                    $('#skills').val(skills);
                    console.log($('#skills').val());
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

function createNewSkillEntry(skill_list, new_skill, level) {

    let tempList = [];
    let intLevel = parseInt(level);
    let strLevel = "";

    tempList.push(new_skill['skill_id']);
    tempList.push(intLevel);

    if (intLevel === 1) {
        strLevel = "<div class='ui small label'>Basic</div>";
    } else if (intLevel === 2) {
        strLevel = "<div class='ui yellow small label'>Novice</div>";
    } else if (intLevel === 3) {
        strLevel = "<div class='ui olive small label'>Intermediate</div>";
    } else if (intLevel === 4) {
        strLevel = "<div class='ui green small label'>Advance</div>";
    } else {
        strLevel = "<div class='ui blue small label'>Expert</div>";
    }

    if (skill_list.length === 0) {
        $('#skill-list')
            .removeClass('placeholder')
            .html(`
                    <div id="skill-list-div" class="ui relaxed divided selection list">
                      <div id="skill-` + new_skill['skill_id'] + `" class="skill item">
                        <i class="large star middle aligned yellow icon"></i>
                        <div class="content">
                          <span class="ui big header">` + new_skill['title'] + `</span>
                          <div class="description">Competence Level ` + strLevel + `</div>
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
                          <div class="description">Competence Level ` + strLevel + `</div>
                        </div>
                    </div>
                `)
    }

    skill_list.push(tempList);
}

function readURL(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            $('#banner-img').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}