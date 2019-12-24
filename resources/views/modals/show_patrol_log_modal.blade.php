@if(Auth::user()->level() >= $constants['access_level']['staff'])
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
            <label>Patrol Type</label>
            <select class="select2-patrol-type" style="width:100%" id="ajax-input-patrol-log-type" name="role" disabled>
              @foreach($constants['patrol_type'] as $item => $value)
                <option value="{{ $item }}">{{ $value }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Patrol Date</label>
            <input type="text" class="form-control" id="ajax-input-patrol-log-date" disabled>
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
            <label>Patrol Description</label>
            <textarea class="form-control" id="ajax-input-patrol-details" rows="6" disabled></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal" id="ajax_new_patrol_log_cancel">Close</button>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $table = $('#tableElement');
    $table.on('click', '#ajax_view_patrol_log_open', function () {

    var id = $(this).val();

      $.ajax({
         type: "POST",
         url: '{{ url('activity/get_data/') }}/'+id,
         success: function(data){
           console.log(data);
            // $("#profile-username-field").val(data['username']);
            $("#ajax_view_patrol_log").modal("toggle");
         }
      }).done(function(data) {});
  });
</script>
@endif