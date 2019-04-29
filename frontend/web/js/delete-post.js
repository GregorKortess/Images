$(document).ready(function () {
    $('a.button-delete-post').click(function () {
        var params = {
            'id': $(this).attr('data-id'),
        };
        $.post('/post/default/deletepost', params ,function (data) {

        });
        return false;
    });
});