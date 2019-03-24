$(document).ready(function () {

    $('#home-content').css('display', 'block');

    $('#main-menu').on('click', '.item', function () {
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
    })

});