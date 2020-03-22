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
        <form id="ajax_submit_patrol_log" autocomplete="off">
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
              <label>Patrol Start Date<sup class="text-danger">*</sup></label>
              <div id="patrol_start_date_datepicker" class="input-group date datepicker">
                <input type="text" class="form-control" id="patrol_start_date" required>
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="patrol-date-error" class="error mt-2 text-danger" for="patrol_start_date" hidden></label>
            </div>

            <div class="form-group">
              <label>Patrol End Date</label>
              <div id="patrol_end_date_datepicker" class="input-group date datepicker">
                <input type="text" class="form-control" id="patrol-end-log-date">
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="patrol-end-log-date-error" class="error mt-2 text-danger" for="patrol-log-date" hidden></label>
            </div>

            <div class="form-group">
              <label>Patrol Start Time<sup class="text-danger">*</sup></label>
              <div class="input-group date" id="patrol-start-time" data-target-input="nearest">
                <div class="input-group" data-target="#patrol-start-time" data-toggle="datetimepicker">
                  <input type="text" class="form-control datetimepicker-input" data-target="#patrol-start-time" id="patrol-start-time-input" required>
                  <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                </div>
              </div>
              <label id="patrol-start_time-error" class="error mt-2 text-danger" for="patrol-start-time" hidden></label>
            </div>

            <div class="form-group">
              <label>Patrol End Time<sup class="text-danger">*</sup></label>
              <div class="input-group date" id="patrol-end-time" data-target-input="nearest">
                <div class="input-group" data-target="#patrol-end-time" data-toggle="datetimepicker">
                  <input type="text" class="form-control datetimepicker-input" data-target="#patrol-end-time" id="patrol-end-time-input" required>
                  <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                </div>
              </div>
              <label id="patrol-end_time-error" class="error mt-2 text-danger" for="patrol-end-time" hidden></label>
            </div>
            <div class="form-group">
              <label>Patrol Description<sup class="text-danger">*</sup></label>
              <textarea class="form-control" id="patrol-details" rows="6" required></textarea>
              <label id="patrol-details-error" class="error mt-2 text-danger" for="patrol-details" hidden></label>
            </div>
              <div class="form-group">
                  <label>How many calls were you a part of?<sup class="text-danger">*</sup></label>
                  <div class="input-group" id="patrol-priorities2" data-target-input="nearest">
                      <input type="number" class="form-control" id="patrol-priorities" required>
                      <div class="input-group-addon input-group-append"><i class=" mdi mdi-apple-keyboard-caps input-group-text"></i></div>
                  </div>
                  <label id="patrol-priorities-error" class="error mt-2 text-danger" for="patrol-priorities" hidden></label>
              </div>
              <div class="form-group">
                  <label>Select Patrol Area<sup class="text-danger">*</sup></label>
                  <select class="js-example-basic-multiple" multiple="multiple" id="patrol-area" style="width:100%" required>
                      @foreach($constants['patrol_area'] as $patrol_area => $value)
                          <option value="{{$value}}">{{$value}}</option>
                      @endforeach
                  </select>
                  <label id="patrol-area-error" class="error mt-2 text-danger" for="patrol-area" hidden></label>
              </div>
              <div class="form-group">
                  <label>Flag this Patrol Log?</label>
                  <div class="form-check form-check-info">
                      <label class="form-check-label"><input type="checkbox" id="flag-patrol-log"> Flag Patrol Log <i class="input-helper"></i><i class="input-helper"></i> <div class="badge badge-pill badge-primary" data-toggle="tooltip" data-placement="right" style="margin-left:2px;" title="By flagging your Patrol Log, you are indicating to staff that you would like your Patrol Log reviewed.">?</div></label>
                      <label id="flag-patrol-log-error" class="error mt-2 text-danger" for="flag-patrol-log" hidden></label>
                  </div>
                  <textarea id="reason-for-flag" class="form-control" style="display: none" rows="6" placeholder="Enter your reason for wanting to Flag this Patrol Log."></textarea>
                  <label id="reason-for-flag-error" class="error mt-2 text-danger" for="reason-for-flag" hidden></label>
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
