$(document).ready(function () {

    $('.close.icon').on('click', function () {
            $(this).closest('.message').transition('fade down');
        }
    );

});