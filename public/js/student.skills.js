$(document).ready(function () {

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
                    $('#skill-list').val(addToSkills(result));
                }
            });
    });

    $('#add').on('click', function (e) {
        if (!confirm('Do you want to save current skill list?')) {
            e.preventDefault();
        }
    });

    $('#reset').on('click', function (e) {
        if (confirm('Your skills will be reset to none. Do you really want to reset current skill list?')) {
            $('#skill-container')
                .addClass('placeholder')
                .html(`<div class="ui icon header">
                            <i class="orange exclamation triangle icon"></i>
                            No Skills are listed yet.
                        </div>`);
            $('#skill-list').val('');
            $('#add, #reset').addClass('disabled')
        } else {
            e.preventDefault();
        }
    })

});

function removeSkill(ele) {
    let skills = $('#skill-list');
    let current_array = skills.val().split(',');
    let removing_item = $(ele).parents('tr').data('index');

    if (confirm('Do you really want to remove this skill?')) {
        let index = $.inArray(removing_item.toString(), current_array);

        current_array.splice(index, 1);
        current_array.splice(index, 1);

        skills.val(current_array);

        if (current_array.length === 0) {
            $(ele).parents('table').remove();
            $('#skill-container')
                .addClass('placeholder')
                .html(`<div class="ui icon header">
                            <i class="orange exclamation triangle icon"></i>
                            No Skills are listed yet.
                        </div>`);
            $('#add, #reset').addClass('disabled')
        } else {
            $('#add, #reset').removeClass('disabled');
            $(ele).parents('tr').remove();
        }
    }
}

function addToSkills(result) {
    let skill_list = $('#skill-list').val().split(',');
    let skill_array_temp = [];
    let intLevel;
    let strLevel;
    let tempArray = [];

    $('#add, #reset').removeClass('disabled');

    if (skill_list.length !== 1) {
        skill_array_temp = skill_list;
    }

    while (true) {
        intLevel = parseInt(prompt('Competence Level for ' + result['title'] +
            '.\n(Input a integer between 1-5)\n1 - Basic\n2 - Novice\n3 - Intermediate\n4 - Advance\n5 - Expert'));
        if (intLevel > 0 && intLevel < 6) {
            break;
        }
    }

    strLevel = makeLevelLabel(intLevel);

    if (skill_array_temp.length === 0) {
        $('#skill-container')
            .removeClass('placeholder')
            .html(`<table id="skill-table" class="ui selection table">
                    <tbody></tbody>
               </table>`);
    }

    $('#skill-table tbody').append(`<tr data-index="` + result['skill_id'] + `">
                                     <td>
                                        <span style="font-size: x-large;font-weight: bold">` + result['title'] + `</span><br>
                                        <small style="color: grey;">` + result['category'] + `</small>
                                     </td>
                                     <td class="center aligned"> ` + strLevel + `</td>
                                     <td class="right aligned">
                                        <button type="button" class="ui red left icon button" onclick="removeSkill(this)">
                                            <i class="times icon"></i>
                                        </button>
                                     </td>
                                  </tr>`);

    tempArray.push(result['skill_id'], intLevel);
    skill_array_temp.push(tempArray);
    return skill_array_temp;
}

function makeLevelLabel(intLevel) {
    let strLevel = '';

    if (intLevel === 1) {
        strLevel = "<div class='ui label'>Competence Level<div class='detail'>Basic</div></div>";
    } else if (intLevel === 2) {
        strLevel = "<div class='ui yellow label'>Competence Level<div class='detail'>Novice</div></div>";
    } else if (intLevel === 3) {
        strLevel = "<div class='ui olive label'>Competence Level<div class='detail'>Intermediate</div></div>";
    } else if (intLevel === 4) {
        strLevel = "<div class='ui green label'>Competence Level<div class='detail'>Advance</div></div>";
    } else {
        strLevel = "<div class='ui blue label'>Competence Level<div class='detail'>Expert</div></div>";
    }

    return strLevel;
}