var elements = [
  '#ajax-input-patrol-log-type',
  '#ajax-input-patrol-log-start-date',
  '#ajax-input-patrol-log-end-date',
  '#ajax-input-patrol-start-time',
  '#ajax-input-patrol-end-time',
  '#ajax-input-patrol-details',
  '#ajax-input-patrol-area',
  '#ajax-input-patrol-priorities',
];

$("#ajax_edit_patrol_log-button").click(function(e){
  e.preventDefault();
  for (var element in elements) {
    $(elements[element]).prop("disabled", false); // Element(s) are now enabled.
  }
  $('#ajax_edit_patrol_log-button').prop('hidden', true);
  $('#ajax_submit_edit_patrol_log-button').prop('hidden', false);

  (function($) {
    'use strict';

    if ($(".select2-patrol-type").length) {
      $('.select2-patrol-type').select2({
          minimumResultsForSearch: -1
      });
    }
  })(jQuery);

  (function($) {
    'use strict';
    if ($("#patrol-start-time-input").length) {
      $('#patrol-start-time-input').datetimepicker({
        format: 'HH:mm'
      });
    }
    if ($("#patrol-end-time-input").length) {
      $('#patrol-end-time-input').datetimepicker({
        format: 'LT'
      });
    }
    if ($("#ajax-input-patrol-log-start-date").length) {
      $('#ajax-input-patrol-log-start-date').datepicker({
        format: 'yyyy-mm-dd',
        enableOnReadonly: true,
        todayHighlight: true,
        autoclose: true
      });
    }
    if ($("#ajax-input-patrol-log-end-date").length) {
      $('#ajax-input-patrol-log-end-date').datepicker({
        format: 'yyyy-mm-dd',
        enableOnReadonly: true,
        todayHighlight: true,
        autoclose: true
      });
    }
  })(jQuery);

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
  var patrol_area = $('#ajax-input-patrol-area').val();
  var patrol_priorities = $('#ajax-input-patrol-priorities').val();

  $.ajax({
    type: 'POST',
    url: $url_edit_patrol_log+id,
    data: { type:type, patrol_start_date:patrol_start_date, patrol_end_date:patrol_end_date, start_time:start_time, end_time:end_time, details:details, patrol_area:patrol_area, patrol_priorities:patrol_priorities }, 
    success: function() {
        var toast_heading = "Patrol Log Edited!";
        var toast_text = "The changes have been made and saved into the database.";
        var toast_icon = "success";
        var toast_color = "#f96868";
        globalToast(toast_heading, toast_text, toast_icon, toast_color);

        for (var element in elements) {
          $(elements[element]).prop("disabled", true); // Element(s) are now disabled again.
        }
        $('#ajax_edit_patrol_log-button').prop('hidden', false);
        $('#ajax_submit_edit_patrol_log-button').prop('hidden', true);
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