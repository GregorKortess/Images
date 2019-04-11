$(document).ready(function () {
    $('a.button-delete').click(function () {
        var params = {
            'id': $(this).attr('data-id'),
            'commentText': $(this).attr('data-text'),
            'commentAuthor': $(this).attr('data-user')
        };
        $.post('/post/default/deletecomment', params ,function (data) {

        });
        return false;
    });
});