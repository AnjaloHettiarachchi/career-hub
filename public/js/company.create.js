$(document).ready(function () {
    $("#avatar").change(function () {
        readURL(this);
    });
    $('.ui.dropdown').dropdown();

    $('#aoe').change(function () {
        if ($('#aoe :selected').html() === 'Other') {
            $('#div-aoe-alt').css('display', 'block')
        } else {
            $('#div-aoe-alt').css('display', 'none')
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