@inject('baseXCS', 'App\Http\Controllers\BaseXCS')

@if(Auth::user()->level() >= $constants['access_level']['sit'])
<!-- Submitting Disciplinary Actions - Modal -->
<div class="modal fade" id="ajax_add_disciplinary_action-modal" tabindex="-1" role="dialog" aria-labelledby="ajax_add_disciplinary_action-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="ajax_add_disciplinary_action-label">Recording a Disciplinary Action</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="ajax_add_disciplinary_action-form">
          <div class="modal-body">

            <div class="form-group">
              <label>Issued To</label><sup class="text-danger">*</sup>
              <select class="ajax_search_member-class" style="width:100%" id="ajax_add_disciplinary_action-input_issued_to" required>
                  <option></option>
                @foreach($baseXCS::getAllMembers() as $id => $user)
                  <option value="{{ $id }}">{{ $user }}</option>
                @endforeach
              </select>
              <label id="ajax_add_disciplinary_action-input_issued_to-error" class="error mt-2 text-danger" for="ajax_add_disciplinary_action-input_issued_to" hidden></label>
            </div>

            <div class="form-group">
              <label>Discipline Date</label><sup class="text-danger">*</sup>
              <div id="ajax_add_disciplinary_action-date" class="input-group date datepicker">
                <input type="text" class="form-control" id="ajax_add_disciplinary_action-input_date" required>
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="ajax_add_disciplinary_action-input_date-error" class="error mt-2 text-danger" for="ajax_add_disciplinary_action-input_date" hidden></label>
            </div>

            <div class="form-group">
              <label>Disciplinary Action</label><sup class="text-danger">*</sup>
              <select class="antelope_global_select_single" style="width:100%" id="ajax_add_disciplinary_action-input_type" required>
                @foreach($constants['disciplinary_actions'] as $value => $key)
                  <option value="{{ $value }}">{{ $key }}</option>
                @endforeach
              </select>
              <label id="ajax_add_disciplinary_action-input_type-error" class="error mt-2 text-danger" for="ajax_add_disciplinary_action-input_type" hidden></label>
            </div>

            <div class="form-group">
              <label>Disciplinary Synopsis</label><sup class="text-danger">*</sup>
              <textarea class="form-control" id="ajax_add_disciplinary_action-details" rows="6" required></textarea>
              <label id="ajax_add_disciplinary_action-details-error" class="error mt-2 text-danger" for="ajax_add_disciplinary_action-details" hidden></label>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Record</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="ajax_add_disciplinary_action-cancel">Cancel</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

  var elements = {
    '#ajax_add_disciplinary_action-input_issued_to' : '#ajax_add_disciplinary_action-input_issued_to-error',
    '#ajax_add_disciplinary_action-input_date' : '#ajax_add_disciplinary_action-input_date-error',
    '#ajax_add_disciplinary_action-input_type' : '#ajax_add_disciplinary_action-input_type-error',
    '#ajax_add_disciplinary_action-details' : '#ajax_add_disciplinary_action-details-error',
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

  $('#ajax_add_disciplinary_action-form').on('submit', function(e) {
    e.preventDefault();
    var issued_to = $('#ajax_add_disciplinary_action-input_issued_to').val();
    var date = $('#ajax_add_disciplinary_action-input_date').val();
    var type = $('#ajax_add_disciplinary_action-input_type').val();
    var details = $('#ajax_add_disciplinary_action-details').val();

    // this is really crappy but i just can't be asked anymore
    for (var element in elements) {
      $(element).parent().removeClass('has-danger');
      $(element).removeClass('form-control-danger');
      $(elements[element]).prop('hidden', true);
      $(elements[element]).empty();
    }


    $.ajax({
      type: 'POST',
      url: '{{ url('discipline/submit') }}',
      data: { issued_to:issued_to, date:date, type:type, details:details },
      success: function() {
        $('#ajax_add_disciplinary_action-cancel').click();
        for (var element in elements) {
          $(element).parent().removeClass('has-danger');
          $(element).removeClass('form-control-danger');
          $(elements[element]).prop('hidden', true);
          $(element).val('');
          $(elements[element]).empty();
        }
        var toast_heading = "Discriplinary Action Recorded!";
        var toast_text = "The disciplinary action has been recorded and has been inserted into our database.";
        var toast_icon = "success";
        var toast_color = "#f96868";
        globalToast(toast_heading, toast_text, toast_icon, toast_color);
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
          }
        }
      }
    });
  });

</script>
@endif