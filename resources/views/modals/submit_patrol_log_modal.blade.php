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
              <select class="js-example-basic-single" style="width:100%" id="patrol-log-type" name="role">
                @foreach($constants['patrol_type'] as $item => $value)
                  <option value="{{ $item }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Patrol Date (required)</label>
              <div id="datepicker-popup" class="input-group date datepicker">
                <input type="text" class="form-control" id="patrol-log-date" required>
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
            </div>

            <div class="form-group">
              <label>Patrol Start Time (required)</label>
              <div class="input-group date" id="patrol-start-time" data-target-input="nearest">
                <div class="input-group" data-target="#patrol-start-time" data-toggle="datetimepicker">
                  <input type="text" class="form-control datetimepicker-input" data-target="#patrol-start-time" />
                  <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Patrol End Time (required)</label>
              <div class="input-group date" id="patrol-end-time" data-target-input="nearest">
                <div class="input-group" data-target="#patrol-end-time" data-toggle="datetimepicker">
                  <input type="text" class="form-control datetimepicker-input" data-target="#patrol-end-time" />
                  <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Patrol Description (required)</label>
              <textarea class="form-control" id="patrol-details" rows="6"></textarea>
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
  (function($) {
    'use strict';

    if ($(".js-example-basic-single").length) {
      $(".js-example-basic-single").select2();
    }
    if ($(".js-example-basic-multiple").length) {
      $(".js-example-basic-multiple").select2();
    }
  })(jQuery);

  (function($) {
  'use strict';
  if ($("#patrol-start-time").length) {
    $('#patrol-start-time').datetimepicker({
      format: 'LT'
    });
  }
  if ($("#patrol-end-time").length) {
    $('#patrol-end-time').datetimepicker({
      format: 'LT'
    });
  }
  if ($("#datepicker-popup").length) {
    $('#datepicker-popup').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
    });
  }
})(jQuery);
</script>
@endif