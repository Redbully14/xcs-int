$('#absence_modal_form').on('submit', function(e) {
  e.preventDefault();
  var start_date = $('#absence_modal_start_date-input').val();
  var end_date = $('#absence_modal_end_date-input').val();
  var forum_post = $('#absence_modal_forum_post').val();
  var elements = {
    '#absence_modal_start_date-input' : '#absence_modal_start_date-error',
    '#absence_modal_end_date-input' : '#absence_modal_end_date-error',
    '#absence_modal_forum_post' : '#absence_modal_forum_post-error',
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
    url: $url_submit_absence,
    data: {start_date:start_date, end_date:end_date, forum_post:forum_post},
    success: function() {
      $('#absence_modal_cancel').click();
      for (var element in elements) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
        $(elements[element]).prop('hidden', true);
        $(element).val('');
        $(elements[element]).empty();
      }
      var toast_heading = "Absence Submitted!";
      var toast_text = "The absence has been submitted and recorded within the system.";
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
      var toast_heading = "Absence Submission Failed!";
      var toast_text = "Please double check the fields to ensure everything is correct.";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color)
      var errors = data['responseJSON'].errors;

      for (var key in errors) {
        switch (key) {
          case 'start_date':
            var element = '#absence_modal_start_date-input';
            var label = '#absence_modal_start_date-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'end_date':
            var element = '#absence_modal_end_date-input';
            var label = '#absence_modal_end_date-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'forum_post':
            var element = '#absence_modal_forum_post';
            var label = '#absence_modal_forum_post-error';
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
  if ($("#absence_modal_start_date").length) {
    $('#absence_modal_start_date').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
      autoclose: true
    });
  }
  if ($("#absence_modal_end_date").length) {
    $('#absence_modal_end_date').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
      autoclose: true
    });
  }
})(jQuery);