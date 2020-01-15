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
              <label id="ajax_add_disciplinary_action-input_issued_to-error" class="error mt-2 text-danger" for="ajax_add_disciplinary_action-input_issued_to" hidden></label>
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
    '#ajax_add_disciplinary_action-input_issued_to' : '#ajax_add_disciplinary_action-input_issued_to-error'
  };

    $( "#ajax_add_disciplinary_action-button" ).click(function() {
    for (var element in elements) {
      $(element).parent().removeClass('has-danger');
      $(element).removeClass('form-control-danger');
      $(elements[element]).prop('hidden', true);
      $(elements[element]).empty();
    }
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

</script>
@endif