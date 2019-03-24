$(document).ready(function () {
    $("#avatar").change(function () {
        readURL(this);
    });

    $('#fac, #uni').dropdown();

    $('#con_num').mask('(000) 000 0000');

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
                    $('#fac-field, #uni-field').css('display', 'block');

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
    })

    $('#sit').dropdown({
        onChange: function (val, text) {
            $('#prov-id-field')
                .css('display', 'block');
            $('#prov_id').attr('placeholder', 'Student ' + text + ' Card No.')
        }
    })

});

function readURL(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}