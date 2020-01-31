@inject('baseXCS', 'App\Http\Controllers\BaseXCS')

@if(Auth::user()->level() >= $constants['access_level']['sit'])
<!-- Submitting Disciplinary Actions - Modal -->
<!-- Open modal with button id #ajax_add_disciplinary_action-button -->
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
			  @if(\Request::is('profile/*'))
			    <label>Issuing to <span class="text-danger font-weight-bold">{{ $user_data['name'] ." ". $user_data['department_id'] }}</span></label>
                <input type="hidden" id="ajax_add_disciplinary_action-input_issued_to" value="{{ $user_data['id'] }}" />
			  @else
                <label>Issued To</label><sup class="text-danger">*</sup>
                <select class="ajax_search_member-class" style="width:100%" id="ajax_add_disciplinary_action-input_issued_to" required>
                  <option></option>
                  @foreach($baseXCS::getAllMembers() as $id => $user)
                    <option value="{{ $id }}">{{ $user }}</option>
                  @endforeach
                </select>
			  @endif
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

            <div class="form-group">
              <label>Custom Expiry Date</label>
              <div id="ajax_add_disciplinary_action-custom_expiry" class="input-group date datepicker">
                <input type="text" class="form-control" id="ajax_add_disciplinary_action-input_custom_expiry">
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="ajax_add_disciplinary_action-input_custom_expiry-error" class="error mt-2 text-danger" for="ajax_add_disciplinary_action-input_custom_expiry" hidden></label>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="ajax_add_disciplinary_action-cancel">Cancel</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var $url_add_disciplinary_action_modal = '{{ url('discipline/submit') }}';
</script>
<script src="/js/modals/add_disciplinary_action_modal.js"></script>
@endif