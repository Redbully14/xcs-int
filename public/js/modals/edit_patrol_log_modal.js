var elements = [
  '#ajax-input-patrol-log-type',
  '#ajax-input-patrol-log-start-date',
  '#ajax-input-patrol-log-end-date',
  '#ajax-input-patrol-start-time',
  '#ajax-input-patrol-end-time',
  '#ajax-input-patrol-details',
];

$("#ajax_edit_patrol_log-button").click(function(e){
  e.preventDefault();
  for (var element in elements) {
    $(elements[element]).prop("disabled", false); // Element(s) are now enabled.
  }
  $('#ajax_edit_patrol_log-button').prop('hidden', true);
  $('#ajax_submit_edit_patrol_log-button').prop('hidden', false);
});

$('#ajax_edit_patrol_log').on('submit', function(e) {
  e.preventDefault();
  var id = $('#ajax_submit_edit_patrol_log-button').val();
  var type = $('#ajax-input-patrol-log-type').val();
  var patrol_start_date = $('#ajax-input-patrol-log-start-date').val();
  var patrol_end_date = $('#ajax-input-patrol-log-end-date').val();
  var start_time = $('#ajax-input-patrol-start-time').val();
  var end_time = $('#ajax-input-patrol-end-time').val();
  var details = $('#ajax-input-patrol-details').val();

  $.ajax({
    type: 'POST',
    url: $url_edit_patrol_log+id,
    data: { type:type, patrol_start_date:patrol_start_date, patrol_end_date:patrol_end_date, start_time:start_time, end_time:end_time, details:details }, 
    success: function() {
        var toast_heading = "Patrol Log Edited!";
        var toast_text = "The changes have been made and saved into the database.";
        var toast_icon = "success";
        var toast_color = "#f96868";
        globalToast(toast_heading, toast_text, toast_icon, toast_color);
      },
    error: function(data) {
      var toast_heading = "Patrol Log Editing Failed!";
      var toast_text = "Please double check the fields to ensure everything is correct.";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color)
      var errors = data['responseJSON'].errors;
      console.log(errors);
    }
  });
});