$(document).ready(function () {

    $('.ui.accordion').accordion();

    $('#fac, #uni, #sit').dropdown();

    $.ajax({
        url: '/student/degList',
        method: 'GET',
        success: function (res) {
            $('.ui.search').search({
                type: 'category',
                source: res,
                searchFields: ['title'],
                transition: 'slide down',
                onSelect: function (res) {

                    $('#deg').val(res['deg_id']);
                    $('#fac').dropdown(
                        'set selected', res['fac_id']
                    ).addClass('disabled');
                    $('#uni').dropdown(
                        'set selected', res['uni_id']
                    ).addClass('disabled');
                }
            })
        }
    });

    $('#home-content').css('display', 'block');

    $('#main-menu').on('click', '.item', function () {
        // console.log($(this));
        $('#main-menu .item').removeClass('active');
        $(this).addClass('active');
        $('.content-div').css('display', 'none');

        if ($(this).hasClass('home')) {
            $('#home-content').css('display', 'block');
        } else if ($(this).hasClass('con')) {
            $('#con-content').css('display', 'block');
        } else if ($(this).hasClass('ach')) {
            $('#ach-content').css('display', 'block');
        } else if ($(this).hasClass('find')) {
            $('#find-content').css('display', 'block');
        } else {
            $('#settings-content').css('display', 'block');
        }
    });

    $('.ui.progress').progress('increment');

    $('.prog.label').parents('.indicating.progress').each(function () {
        switch ($(this).data('value')) {
            case 1 : {
                $(this).children('.prog.label').html('Competence Level: Basic');
                break;
            }
            case 2 : {
                $(this).children('.prog.label').html('Competence Level: Novice');
                break;
            }
            case 3 : {
                $(this).children('.prog.label').html('Competence Level: Intermediate');
                break;
            }
            case 4 : {
                $(this).children('.prog.label').html('Competence Level: Advance');
                break;
            }
            default : {
                $(this).children('.prog.label').html('Competence Level: Expert');
                break;
            }
        }
    });

    $('#new').on('click', function () {
        $('.ui.modal').modal('show')
    })

});

function showTab(name) {

    $('#main-menu .item').removeClass('active');
    $('.content-div').css('display', 'none');

    switch (name) {
        case 'home': {
            $('#main-menu .home.item').addClass('active');
            $('#home-content').css('display', 'block');
            break;
        }
        case 'con': {
            $('#main-menu .con.item').addClass('active');
            $('#con-content').css('display', 'block');
            break;
        }
        case 'skill' || 'ach' : {
            $('#main-menu .ach.item').addClass('active');
            $('#ach-content').css('display', 'block');
            break;
        }
        case 'find': {
            $('#main-menu .find.item').addClass('active');
            $('#find-content').css('display', 'block');
            break;
        }
        default : {
            $('#main-menu .settings.item').addClass('active');
            $('#settings-content').css('display', 'block');
            break;
        }
    }

}