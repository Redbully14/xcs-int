$('#ajax_submit_patrol_log').on('submit', function(e) {
  e.preventDefault();
  var type = $('#patrol-log-type').val();
  var patrol_start_date = $('#patrol_start_date').val();
  var patrol_end_date = $('#patrol-end-log-date').val();
  var start_time = $('#patrol-start-time-input').val();
  var end_time = $('#patrol-end-time-input').val();
  var details = $('#patrol-details').val();
  var patrol_area = $('#patrol-area').val();
  var patrol_priorities = $('#patrol-priorities').val();
  var flag_patrol_log = $('#flag-patrol-log').is(":checked");
  var reason_for_flag = $('#reason-for-flag').val();

  var elements = {
    '#patrol_start_date' : '#patrol-date-error',
    '#patrol-start-time-input' : '#patrol-start_time-error',
    '#patrol-end-time-input' : '#patrol-end_time-error',
    // yes this is dirty but it will do
    '#patrol-start-time' : '#patrol-start_time-error',
    '#patrol-end-time' : '#patrol-end_time-error',
    '#patrol-details' : '#patrol-details-error',
    '#patrol-end-log-date' : '#patrol-end-log-date-error',
    '#patrol-area' : '#patrol-area-error',
    '#patrol-priorities' : '#patrol-priorities-error',
    '#flag-patrol-log' : '#flag-patrol-log-error',
    '#reason-for-flag' : '#reason-for-flag-error'
  };

  // this is really crappy but i just can't be asked anymore
  for (var element in elements) {
    $(element).parent().removeClass('has-danger');
    $(element).removeClass('form-control-danger');
    $(elements[element]).prop('hidden', true);
    $(elements[element]).empty();
  }

  $.ajax({
    type: 'POST',
    url: $url_submit_patrol_log,
    data: {type:type, patrol_start_date:patrol_start_date, patrol_end_date:patrol_end_date, start_time:start_time, end_time:end_time, details:details, patrol_area:patrol_area, patrol_priorities:patrol_priorities, flag:flag_patrol_log, flag_reason:reason_for_flag},
    success: function() {
      $('#ajax_new_patrol_log_cancel').click();
      for (var element in elements) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
        $(elements[element]).prop('hidden', true);
        $(element).val('');
        $(elements[element]).empty();
      }
      // Specifically empties the AOP select
      $('#patrol-area').val(null).trigger('change');

      var toast_heading = "Patrol Log Submitted!";
      var toast_text = "The patrol log has been submitted and has been logged into our database.";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    },
    error: function(data) {
      for (var element in elements) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
        $(elements[element]).prop('hidden', true);
        $(elements[element]).empty();
      }
      var toast_heading = "Patrol Submission Failed!";
      var toast_text = "Please double check the fields to ensure everything is correct.";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color)
      var errors = data['responseJSON'].errors;

      for (var key in errors) {
        switch (key) {
          case 'patrol_date':
            var element = '#patrol_start_date';
            var label = '#patrol-date-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'patrol_end_date':
            var element = '#patrol-end-log-date';
            var label = '#patrol-end-log-date-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'start_time':
            var element = '#patrol-start-time';
            var label = '#patrol-start_time-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'end_time':
            var element = '#patrol-end-time';
            var label = '#patrol-end_time-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'details':
            var element = '#patrol-details';
            var label = '#patrol-details-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'patrol_area':
                var element = '#patrol-area';
                var label = '#patrol-area-error';
                $(element).parent().addClass('has-danger');
                $(element).addClass('form-control-danger');
                $(label).append(errors[key]);
                $(label).prop('hidden', false);
          break;
          case 'patrol_priorities':
                var element = '#patrol-priorities2';
                var label = '#patrol-priorities-error';
                $(element).parent().addClass('has-danger');
                $(element).addClass('form-control-danger');
                $(label).append(errors[key]);
                $(label).prop('hidden', false);
          break;
        }
      }
    }
  });
});

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
  if ($("#patrol-start-time").length) {
    $('#patrol-start-time').datetimepicker({
      format: 'LT'
    });
  }
  if ($("#patrol-end-time").length) {
    $('#patrol-end-time').datetimepicker({
      format: 'LT'
    });
  }
  if ($("#patrol_start_date_datepicker").length) {
    $('#patrol_start_date_datepicker').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
      autoclose: true
    });
  }
  if ($("#patrol_end_date_datepicker").length) {
    $('#patrol_end_date_datepicker').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
      autoclose: true
    });
  }
})(jQuery);

$(document).on('click', 'input[id="flag-patrol-log"]', function() {
    let area = $('#reason-for-flag');
    if (this.checked) {
        area.show();
    } else {
        area.hide();
    }
});
