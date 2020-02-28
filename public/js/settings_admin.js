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
      var toast_text = "The Quick Link has been added and is now publicly visible! Please refresh the page to edit it!";
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

$('#admin_manage_quicklink').on('submit', function(e) {
  e.preventDefault();

  // i fucking hate javascript
  // me too
  let data = {};
  let c = 1;
  for(let count = 1; count <= $admin_manage_quicklink_count; c++) {
    if ($('#admin_manage_quicklink-type-'+c).length) {
        if ($('#admin_manage_quicklink-type-'+c)) {
            var type = $('#admin_manage_quicklink-type-' + c).val();
            var title = $('#admin_manage_quicklink-title-' + c).val();
            var link = $('#admin_manage_quicklink-link-' + c).val();
            var id = c;
            data[c] = [type, title, link, id];
            count++;
        }
    }
  };

  if (Object.keys(data).length) {
      $.ajax({
          type: 'POST',
          url: $url_manage_quicklink,
          data: {data},
          success: function () {
              var toast_heading = "Quick Links Saved!";
              var toast_text = "The Quick Links have been saved and is now publicly visible!";
              var toast_icon = "success";
              var toast_color = "#f96868";
              globalToast(toast_heading, toast_text, toast_icon, toast_color);
          },
          error: function (data) {
              console.log(error);
              var toast_heading = "Error!";
              var toast_text = "good job you broke it somehow";
              var toast_icon = "error";
              var toast_color = "#f2a654";
              globalToast(toast_heading, toast_text, toast_icon, toast_color);
          }
      });
  } else {
      var toast_heading = "Error!";
      var toast_text = "Not sure how you managed to do that, but yeah, you broke it. 10 points";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
  }
});
