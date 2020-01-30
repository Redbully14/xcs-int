@if(Auth::user()->level() >= $constants['access_level']['member'])
<!-- Submitting a Patrol Log - Modal -->
<!-- Open modal with button id #ajax_open_patrol_log_submission -->
<div class="modal fade" id="ajax_new_patrol_log" tabindex="-1" role="dialog" aria-labelledby="ajax_new_patrol_log" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Submit a Patrol Log</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="ajax_submit_patrol_log">
          <div class="modal-body">

            <div class="form-group">
              <label>Patrol Type</label>
              <select class="select2-patrol-type" style="width:100%" id="patrol-log-type" name="role">
                @foreach($constants['patrol_type'] as $item => $value)
                  <option value="{{ $item }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Patrol Start Date (required)</label>
              <div id="patrol_start_date_datepicker" class="input-group date datepicker">
                <input type="text" class="form-control" id="patrol_start_date" required>
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="patrol-date-error" class="error mt-2 text-danger" for="patrol_start_date" hidden></label>
            </div>

            <div class="form-group">
              <label>Patrol End Date (optional)</label>
              <div id="patrol_end_date_datepicker" class="input-group date datepicker">
                <input type="text" class="form-control" id="patrol-end-log-date">
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="patrol-end-log-date-error" class="error mt-2 text-danger" for="patrol-log-date" hidden></label>
            </div>

            <div class="form-group">
              <label>Patrol Start Time (required)</label>
              <div class="input-group date" id="patrol-start-time" data-target-input="nearest">
                <div class="input-group" data-target="#patrol-start-time" data-toggle="datetimepicker">
                  <input type="text" class="form-control datetimepicker-input" data-target="#patrol-start-time" id="patrol-start-time-input" />
                  <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                </div>
              </div>
              <label id="patrol-start_time-error" class="error mt-2 text-danger" for="patrol-start-time" hidden></label>
            </div>

            <div class="form-group">
              <label>Patrol End Time (required)</label>
              <div class="input-group date" id="patrol-end-time" data-target-input="nearest">
                <div class="input-group" data-target="#patrol-end-time" data-toggle="datetimepicker">
                  <input type="text" class="form-control datetimepicker-input" data-target="#patrol-end-time" id="patrol-end-time-input" />
                  <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                </div>
              </div>
              <label id="patrol-end_time-error" class="error mt-2 text-danger" for="patrol-end-time" hidden></label>
            </div>
            <div class="form-group">
              <label>Patrol Description (required)</label>
              <textarea class="form-control" id="patrol-details" rows="6"></textarea>
              <label id="patrol-details-error" class="error mt-2 text-danger" for="patrol-details" hidden></label>
            </div>
              <div class="form-group">
                  <label>Select AOP</label>
                  <select class="js-example-basic-multiple" multiple="multiple" id="patrol-aop" style="width:100%">
                      <option value="BC">Blaine County</option>
                      <option value="LS">Los Santos</option>
                      <option value="SW">State Wide</option>
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="ajax_new_patrol_log_cancel">Cancel</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var $url_submit_patrol_log = '{{ url('activity/submit') }}';
</script>
<script src="/js/modals/submit_patrol_log_modal.js"></script>
@endif