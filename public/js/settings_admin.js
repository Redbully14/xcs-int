$('#admin_add_quicklink').on('submit', function(e) {
  e.preventDefault();
  var type = $('#admin_add_quicklink-type').val();
  var title = $('#admin_add_quicklink-title').val();
  var link = $('#admin_add_quicklink-link').val();

  $.ajax({
    type: 'POST',
    url: $url_add_quicklink,
    data: {type:type, title:title, link:link},
    success: function() {
      var toast_heading = "Quick Link Added!";
      var toast_text = "The Quick Link has been added and is now publicly visible!";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    },
    error: function(data) {
      var toast_heading = "Error!";
      var toast_text = "good job you broke it somehow";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    }
  });
});