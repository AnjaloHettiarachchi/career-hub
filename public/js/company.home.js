$(document).ready(function () {

    $('#home-content').css('display', 'block');

    $('.ui.accordion').accordion();

    $('#aoe').dropdown();

    $('#main-menu').on('click', '.item', function () {
        $('#main-menu .item').removeClass('active');
        $(this).addClass('active');
        $('.content-div').css('display', 'none');

        if ($(this).hasClass('home')) {
            $('#home-content').css('display', 'block');
        } else if ($(this).hasClass('con')) {
            $('#con-content').css('display', 'block');
        } else if ($(this).hasClass('op')) {
            $('#op-content').css('display', 'block');
        } else if ($(this).hasClass('find')) {
            $('#find-content').css('display', 'block');
        } else {
            $('#settings-content').css('display', 'block');
        }
    });

});