@if(Auth::user()->level() >= $constants['access_level']['member'])
<!-- Submitting a Patrol Log - Modal -->
<!-- Open modal with button id #absence_modal_button -->
<div class="modal fade" id="absence_modal" tabindex="-1" role="dialog" aria-labelledby="absence_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Submit an LOA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="absence_modal_form">
          <div class="modal-body">

            <div class="form-group">
              <label>LOA Start Date</label><sup class="text-danger">*</sup>
              <div id="absence_modal_start_date" class="input-group date datepicker">
                <input type="text" class="form-control" id="absence_modal_start_date-input" autocomplete="off" required>
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="absence_modal_start_date-error" class="error mt-2 text-danger" for="absence_modal_start_date" hidden></label>
            </div>

            <div class="form-group">
              <label>LOA End Date</label><sup class="text-danger">*</sup>
              <div id="absence_modal_end_date" class="input-group date datepicker">
                <input type="text" class="form-control" id="absence_modal_end_date-input" autocomplete="off" required>
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="absence_modal_end_date-error" class="error mt-2 text-danger" for="absence_modal_end_date" hidden></label>
            </div>

            <div class="form-group">
              <label>LOA Forum Post Link</label><sup class="text-danger">*</sup>
              <input type="url" class="form-control p_input" required id="absence_modal_forum_post" name="absence_modal_forum_post" autocomplete="off">
              <label id="absence_modal_forum_post-error" class="error mt-2 text-danger" for="absence_modal_forum_post" hidden></label>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="absence_modal_cancel">Cancel</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var $url_submit_absence = '{{ url('absence/submit') }}';
</script>
<script src="/js/modals/submit_absence_modal.js"></script>
@endif
