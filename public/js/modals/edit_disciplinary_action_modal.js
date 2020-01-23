var elements = {
  '#ajax_edit_disciplinary_action-input_issued_by' : '#ajax_edit_disciplinary_action-input_issued_by-error',
  '#ajax_edit_disciplinary_action-input_date' : '#ajax_edit_disciplinary_action-input_date-error',
  '#ajax_edit_disciplinary_action-input_type' : '#ajax_edit_disciplinary_action-input_type-error',
  '#ajax_edit_disciplinary_action-custom_expiry' : '#ajax_edit_disciplinary_action-custom_expiry-error',
  '#ajax_edit_disciplinary_action-input_dispute_date' : '#ajax_edit_disciplinary_action-input_dispute_date-error',
  '#ajax_edit_disciplinary_action-input_overturn_date' : '#ajax_edit_disciplinary_action-input_overturn_date-error',
  '#ajax_edit_disciplinary_action-input_overturned_by' : '#ajax_edit_disciplinary_action-input_overturned_by-error',
};

if ($("#ajax_edit_disciplinary_action-date").length) {
  $('#ajax_edit_disciplinary_action-date').datepicker({
    enableOnReadonly: true,
    todayHighlight: true,
    autoclose: true
  });
}

if ($("#ajax_edit_disciplinary_action-custom_expiry").length) {
  $('#ajax_edit_disciplinary_action-custom_expiry').datepicker({
    enableOnReadonly: true,
    todayHighlight: true,
    autoclose: true
  });
}

if ($("#ajax_edit_disciplinary_action-dispute_date").length) {
  $('#ajax_edit_disciplinary_action-dispute_date').datepicker({
    enableOnReadonly: true,
    todayHighlight: true,
    autoclose: true
  });
}

if ($("#ajax_edit_disciplinary_action-overturn_date").length) {
  $('#ajax_edit_disciplinary_action-overturn_date').datepicker({
    enableOnReadonly: true,
    todayHighlight: true,
    autoclose: true
  });
}

$table = $($discipline_table);
$table.on('click', '#ajax_edit_disciplinary_action-table', function () {
  for (var element in elements) {
    $(element).parent().removeClass('has-danger');
    $(element).removeClass('form-control-danger');
    $(elements[element]).prop('hidden', true);
    $(elements[element]).empty();
  }
  var id = $(this).val();
  $('#ajax_edit_disciplinary_action').val(id).change();

    $.ajax({
       type: "POST",
       url: $url_edit_disciplinary_action_GET+id,
       success: function(data){
         console.log(data);
         if(data['issued_to_department_id'] == null) {
            var issued_to = data['issued_to_name'];
         } else var issued_to = data['issued_to_name']+' '+data['issued_to_department_id'];
         var discipline_id = $edit_disciplinary_action_constant+id;
         $("#ajax_edit_disciplinary_action-display_id").text(discipline_id);
         $("#ajax_edit_disciplinary_action-display_name").text(issued_to);
         $("#ajax_edit_disciplinary_action-input_issued_by").val(data['issued_by']).change();
         $("#ajax_edit_disciplinary_action-input_date").val(data['discipline_date']);
         $("#ajax_edit_disciplinary_action-input_custom_expiry").val(data['custom_expiry_date']);
         $("#ajax_edit_disciplinary_action-input_type").val(data['type']).change();
         $("#ajax_edit_disciplinary_action-details").val(data['details']);
         $("#ajax_edit_disciplinary_action-input_disputed").prop('checked', data['disputed']);
         $("#ajax_edit_disciplinary_action-input_dispute_date").val(data['disputed_date']);
         $("#ajax_edit_disciplinary_action-input_overturned").prop('checked', data['overturned']);
         $("#ajax_edit_disciplinary_action-input_overturn_date").val(data['overturned_date']);
         $("#ajax_edit_disciplinary_action-input_overturned_by").val(data['overturned_by']).change();
       }
    }).done(function(data) {
      $("#ajax_edit_disciplinary_action-modal").modal("toggle");
    });
});

  $('#ajax_edit_disciplinary_action').on('submit', function(e) {
    e.preventDefault();
    var id = $('#ajax_edit_disciplinary_action').val();
    var issued_by = $('#ajax_edit_disciplinary_action-input_issued_by').val();
    var date = $('#ajax_edit_disciplinary_action-input_date').val();
    var custom_expiry_date = $('#ajax_edit_disciplinary_action-input_custom_expiry').val();
    var type = $('#ajax_edit_disciplinary_action-input_type').val();
    var overturned = $("#ajax_edit_disciplinary_action-input_overturned").prop("checked") ? 1 : 0;
    var overturned_by = $('#ajax_edit_disciplinary_action-input_overturned_by').val();
    var overturned_date = $('#ajax_edit_disciplinary_action-input_overturn_date').val();
    var disputed = $("#ajax_edit_disciplinary_action-input_disputed").prop("checked") ? 1 : 0;
    var disputed_date = $("#ajax_edit_disciplinary_action-input_dispute_date").val();
    var details = $("#ajax_edit_disciplinary_action-details").val();

    $.ajax({
      type: 'POST',
      url: $url_edit_disciplinary_action_POST+id,
      data: { issued_by:issued_by, date:date, custom_expiry_date:custom_expiry_date, type:type, overturned:overturned, overturned_date:overturned_date, overturned_by:overturned_by, disputed:disputed, disputed_date:disputed_date, details:details },
      success: function() {
          for (var element in elements) {
            $(element).parent().removeClass('has-danger');
            $(element).removeClass('form-control-danger');
            $(elements[element]).prop('hidden', true);
            $(elements[element]).empty();
          }
          var toast_heading = "Disciplinary Action Edited!";
          var toast_text = "The changes have been made and saved into the database.";
          var toast_icon = "success";
          var toast_color = "#f96868";
          globalToast(toast_heading, toast_text, toast_icon, toast_color);
          if ($($discipline_table).length) {
            $($discipline_table).DataTable().ajax.reload();
          }
        },
      error: function(data) {
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
        console.log(errors);
        /*
        for (var key in errors) {
          switch (key) {
            case 'name':
              var element = '#profile-name-field';
              var label = '#edit-name-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'website_id':
              var element = '#profile-website-id-field';
              var label = '#edit-website_id-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'username':
              var element = '#profile-username-field';
              var label = '#edit-username-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
        }
      }
    */ //Error handling will be done another time since I have to refactor the entire system
    }
  });
});