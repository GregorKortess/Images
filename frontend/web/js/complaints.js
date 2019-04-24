$(document).ready(function () {
   $('a.button-complain').click(function () {
      var button = $(this);
      var preloader = $(this).find('i.icon-preloader');
      var params = {
          'id': $(this).attr('data-id')
      };
      preloader.show();
      $.post('/post/default/complain', params, function (data) {
          preloader.hide();
          button.addClass('disabled');
          button.html(data.text);
      });
      return false;
   });
});