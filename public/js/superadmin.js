$('#ajax_superadmin_takeover').on('submit', function(e) {
  e.preventDefault();
  var id = $('#ajax_superadmin_takeover-user').val();

  $.ajax({
    type: 'POST',
    url: $url_superadmin_takeover,
    data: {id:id},
    success: function(data) {
      window.location = data.redirect_to;
    },
    error: function(data) {
      var toast_heading = "Takeover Error!";
      var toast_text = "An error has occured, fix it yourself, ur a superadmin!";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    }
  });
});