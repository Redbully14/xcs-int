<!-- Open a patrol log - Modal -->
<!-- Open modal with button id #ajax_view_patrol_log_open -->
<div class="modal fade" id="ajax_view_patrol_log" tabindex="-1" role="dialog" aria-labelledby="ajax_view_patrol_log" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patrol Log</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Submitted by:</label>
            <h5 id="ajax-patrol-log-by"></h5>
          </div>

          <div class="form-group">
            <label>Website ID:</label>
            <h5 id="ajax-patrol-website-id"></h5>
          </div>

          <div class="form-group">
            <label>Patrol Type</label>
            <select class="js-example-basic-single" style="width:100%" id="ajax-input-patrol-log-type" name="patrol_type" disabled>
              @foreach($constants['patrol_type'] as $item => $value)
                <option value="{{ $item }}">{{ $value }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Patrol Start Date</label>
            <input type="text" class="form-control" id="ajax-input-patrol-log-start-date" disabled>
          </div>

          <div class="form-group">
            <label>Patrol End Date</label>
            <input type="text" class="form-control" id="ajax-input-patrol-log-end-date" disabled>
          </div>

          <div class="form-group">
            <label>Patrol Start Time</label>
            <input type="text" class="form-control" id="ajax-input-patrol-start-time" disabled>
          </div>

          <div class="form-group">
            <label>Patrol End Time</label>
            <input type="text" class="form-control" id="ajax-input-patrol-end-time" disabled>
          </div>

          <div class="form-group">
            <label>Total Patrol Time</label>
            <input type="text" class="form-control" id="ajax-input-patrol-total-time" disabled>
          </div>

          <div class="form-group">
            <label>Patrol Description</label>
            <textarea class="form-control" id="ajax-input-patrol-details" rows="6" disabled></textarea>
          </div>

            <div class="form-group">
                <label>Patrol Area</label>
                <input type="text" class="form-control" id="ajax-input-patrol-area" disabled>
            </div>
            <div class="form-group">
                <label>Patrol Priorities</label>
                <input type="text" class="form-control" id="ajax-input-patrol-priorities" disabled/>
            </div>

            <div class="form-group">
                <h5>Flags</h5>
                <label>Self Flag: <span id="ajax-span-self-flag"></span></label>
                <textarea class="form-control" id="ajax-textarea-self-flag" rows="6" placeholder="No details." disabled></textarea>
                <br>
                <label>Automatic Flag: <span id="ajax-span-auto-flag"></span></label>
                <textarea class="form-control" id="ajax-textarea-auto-flag" rows="6" placeholder="No details." disabled></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal" id="ajax_new_patrol_log_cancel">Close</button>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var $url_show_patrol_log = '{{ url('activity/get_data/') }}/';
</script>
<script src="/js/modals/show_patrol_log_modal.js"></script>
