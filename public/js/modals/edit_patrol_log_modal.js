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
  document.getElementById("start-time-datatoggle").setAttribute("data-toggle", "datetimepicker"); 
  document.getElementById("end-time-datatoggle").setAttribute("data-toggle", "datetimepicker"); 

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
    if ($("#ajax-patrol-start-time").length) {
      $('#ajax-patrol-start-time').datetimepicker({
        format: 'HH:mm'
      });
    }
    if ($("#ajax-patrol-end-time").length) {
      $('#ajax-patrol-end-time').datetimepicker({
        format: 'HH:mm'
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

function deleteActivityPopup() {
  let modalNode = $('div[tabindex*="-1"]')
  if (!modalNode) return;
  var id = $('#delete_patrol_log_btn').val();

  modalNode.removeAttr('tabindex');
  modalNode.addClass('js-swal-fixed');

  swal({
      title: 'Are you sure?',
      text: "This is a destructive method, do you really wish to delete this patrol log? Only Antelope Developers are able to restore it.",
      icon: 'warning',
      buttons: {
        confirm: {
          text: "Delete Log",
          value: true,
          visible: true,
          className: "btn btn-danger",
          closeModal: true
        },
        cancel: {
          text: "Cancel",
          value: null,
          visible: true,
          className: "btn btn-primary",
          closeModal: true,
        }
      }
  }).then( function(isConfirm) {
    if(isConfirm) {
      $.ajax({
          type: 'POST',
          url: $url_delete_patrol_log + id,
          success: function() {
              var toast_heading = "Log Deleted!";
              var toast_text = "This log has been fully deleted from our database.";
              var toast_icon = "success";
              var toast_color = "#f96868";
              globalToast(toast_heading, toast_text, toast_icon, toast_color);
              $('#ajax_show_patrol_log_cancel').click();
              if ($('#tableElement').length) {
                  $('#tableElement').DataTable().ajax.reload();
              }
          },
      });
    }
  })
}

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

  var errormessages = {
    '#ajax-input-patrol-log-start-date' : '#ajax-input-patrol-log-start-date-error',
    '#ajax-input-patrol-start-time' : '#ajax-input-patrol-start-time-error',
    '#ajax-input-patrol-end-time' : '#ajax-input-patrol-end-time-error',
    '#ajax-input-patrol-details' : '#ajax-input-patrol-details-error',
    '#ajax-input-patrol-log-end-date' : '#ajax-input-patrol-log-end-date-error',
    '#ajax-input-patrol-area' : '#ajax-input-patrol-area-error',
    '#ajax-input-patrol-priorities' : '#ajax-input-patrol-priorities-error',
  };
  for (var error in errormessages) {
    $(error).parent().removeClass('has-danger');
    $(error).removeClass('form-control-danger');
    $(errormessages[error]).prop('hidden', true);
    $(errormessages[error]).empty();
  }

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

      for (var key in errors) {
        switch (key) {
          case 'patrol_date':
            var element = '#ajax-input-patrol-log-start-date';
            var label = '#ajax-input-patrol-log-start-date-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'patrol_end_date':
            var element = '#ajax-input-patrol-log-end-date';
            var label = '#ajax-input-patrol-log-end-date-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'start_time':
            var element = '#ajax-input-patrol-start-time';
            var label = '#ajax-input-patrol-start-time-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'end_time':
            var element = '#ajax-input-patrol-end-time';
            var label = '#ajax-input-patrol-end-time-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'details':
            var element = '#ajax-input-patrol-details';
            var label = '#ajax-input-patrol-details-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'patrol_area':
            var element = '#ajax-input-patrol-area';
            var label = '#ajax-input-patrol-area-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'patrol_priorities':
            var element = '#ajax-input-patrol-priorities';
            var label = '#ajax-input-patrol-priorities-error';
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