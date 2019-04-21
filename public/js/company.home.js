$(document).ready(function () {

    $('#home-content').css('display', 'block');

    $('.ui.accordion').accordion();

    $('#new').on('click', function () {
        $('.ui.modal').modal('show');
    });

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
        } else {
            $('#settings-content').css('display', 'block');
        }
    });

    $.ajax({
        url: '/company/stuList',
        method: 'GET',
        success: function (res) {

            $('#main-search').search({
                source: res,
                searchFields: ['title'],
                transition: 'slide down',
                onSelect: function (result) {
                    window.location.href = '/student/' + result['stu_id'] + '/home';
                }
            })

        }
    });

});