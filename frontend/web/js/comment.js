$(document).ready(function () {
    $('a.button-comment').click(function () {
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id'),
            'comment': $('#comments').val()
        };
        $.post('/post/default/comment', params ,function (data) {
            if (data.success) {
                button.siblings('.show-comments').html(data.showComments);
            }
        });
        return false;
    });
});