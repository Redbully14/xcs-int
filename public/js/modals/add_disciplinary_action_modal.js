var elements = {
  '#ajax_add_disciplinary_action-input_issued_to' : '#ajax_add_disciplinary_action-input_issued_to-error',
  '#ajax_add_disciplinary_action-input_date' : '#ajax_add_disciplinary_action-input_date-error',
  '#ajax_add_disciplinary_action-input_type' : '#ajax_add_disciplinary_action-input_type-error',
  '#ajax_add_disciplinary_action-details' : '#ajax_add_disciplinary_action-details-error',
  '#ajax_add_disciplinary_action-input_custom_expiry' : '#ajax_add_disciplinary_action-input_custom_expiry-error',
};

$( "#ajax_add_disciplinary_action-button" ).click(function() {
  var id = $(this).val(); // Already supports ID fetching :D
  $("#ajax_add_disciplinary_action-modal").modal("toggle");
});

if ($("#ajax_add_disciplinary_action-date").length) {
  $('#ajax_add_disciplinary_action-date').datepicker({
    enableOnReadonly: true,
    todayHighlight: true,
    autoclose: true
  });
}

if ($("#ajax_add_disciplinary_action-input_custom_expiry").length) {
  $('#ajax_add_disciplinary_action-input_custom_expiry').datepicker({
    enableOnReadonly: true,
    todayHighlight: true,
    autoclose: true
  });
}

$('#ajax_add_disciplinary_action-form').on('submit', function(e) {
  e.preventDefault();
  var issued_to = $('#ajax_add_disciplinary_action-input_issued_to').val();
  var date = $('#ajax_add_disciplinary_action-input_date').val();
  var type = $('#ajax_add_disciplinary_action-input_type').val();
  var details = $('#ajax_add_disciplinary_action-details').val();
  var custom_expiry_date = $('#ajax_add_disciplinary_action-input_custom_expiry').val();

  // this is really crappy but i just can't be asked anymore
  for (var element in elements) {
    $(element).parent().removeClass('has-danger');
    $(element).removeClass('form-control-danger');
    $(elements[element]).prop('hidden', true);
    $(elements[element]).empty();
  }


  $.ajax({
    type: 'POST',
    url: $url_add_disciplinary_action_modal,
    data: { issued_to:issued_to, date:date, type:type, details:details, custom_expiry_date:custom_expiry_date },
    success: function(data) {
      console.log(data);
      $('#ajax_add_disciplinary_action-cancel').click();
      for (var element in elements) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
        $(elements[element]).prop('hidden', true);
        $(element).val('').change();
        $(elements[element]).empty();
      }
      var toast_heading = "Discriplinary Action Recorded!";
      var toast_text = "The disciplinary action has been recorded and has been inserted into our database.";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
      if ($("#ajax_disciplinary_actions_table_element").length) {
        $('#ajax_disciplinary_actions_table_element').DataTable().ajax.reload();
      }
    },
    error: function(data) {
      console.log(data);
      for (var element in elements) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
        $(elements[element]).prop('hidden', true);
        $(elements[element]).empty();
      }
      var toast_heading = "Disciplinary Recording Failed!";
      var toast_text = "Please double check the fields to ensure everything is correct.";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color)
      var errors = data['responseJSON'].errors;

      for (var key in errors) {
        switch (key) {
          case 'issued_to':
            var element = '#ajax_add_disciplinary_action-input_issued_to';
            var label = '#ajax_add_disciplinary_action-input_issued_to-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'date':
            var element = '#ajax_add_disciplinary_action-input_date';
            var label = '#ajax_add_disciplinary_action-input_date-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'type':
            var element = '#ajax_add_disciplinary_action-input_type';
            var label = '#ajax_add_disciplinary_action-input_type-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'details':
            var element = '#ajax_add_disciplinary_action-details';
            var label = '#ajax_add_disciplinary_action-details-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'custom_expiry_date':
            var element = '#ajax_add_disciplinary_action-input_custom_expiry';
            var label = '#ajax_add_disciplinary_action-input_custom_expiry-error';
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