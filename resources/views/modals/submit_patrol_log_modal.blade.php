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
              <label>Patrol Date (required)</label>
              <div id="datepicker-popup" class="input-group date datepicker">
                <input type="text" class="form-control" id="patrol-log-date" required>
                <span class="input-group-addoan input-group-append border-left">
                  <span class="mdi mdi-calendar input-group-text"></span>
                </span>
              </div>
              <label id="patrol-date-error" class="error mt-2 text-danger" for="patrol-log-date" hidden></label>
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
  showSuccessToast_SubmitPAL = function() {
    'use strict';
    $.toast({
      heading: 'Patrol Log Submitted!',
      text: 'The patrol log has been submitted and has been logged into our database.',
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-right'
    })
  };

  showFailToast_SubmitPAL = function() {
    'use strict';
    $.toast({
      heading: 'Patrol Submission Failed!',
      text: 'Please double check the fields to ensure everything is correct.',
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#f2a654',
      position: 'top-right'
    })
  };

  $('#ajax_submit_patrol_log').on('submit', function(e) {
    e.preventDefault();
    var type = $('#patrol-log-type').val();
    var patrol_date = $('#patrol-log-date').val();
    var start_time = $('#patrol-start-time-input').val();
    var end_time = $('#patrol-end-time-input').val();
    var details = $('#patrol-details').val();
    var elements = {
      '#patrol-log-date' : '#patrol-date-error',
      '#patrol-start-time-input' : '#patrol-start_time-error',
      '#patrol-end-time-input' : '#patrol-end_time-error',
      // yes this is dirty but it will do
      '#patrol-start-time' : '#patrol-start_time-error',
      '#patrol-end-time' : '#patrol-end_time-error',
      '#patrol-details' : '#patrol-details-error',
    };

    // this is really crappy but i just can't be asked anymore
    for (var element in elements) {
      $(element).parent().removeClass('has-danger');
      $(element).removeClass('form-control-danger');
      $(elements[element]).prop('hidden', true);
      $(elements[element]).empty();
    }

    $.ajax({
      type: 'POST',
      url: '{{ url('activity/submit') }}',
      data: {type:type, patrol_date:patrol_date, start_time:start_time, end_time:end_time, details:details},
      success: function() {
        $('#ajax_new_patrol_log_cancel').click();
        for (var element in elements) {
          $(element).parent().removeClass('has-danger');
          $(element).removeClass('form-control-danger');
          $(elements[element]).prop('hidden', true);
          $(element).val('');
          $(elements[element]).empty();
        }
        showSuccessToast_SubmitPAL();
      },
      error: function(data) {
        for (var element in elements) {
          $(element).parent().removeClass('has-danger');
          $(element).removeClass('form-control-danger');
          $(elements[element]).prop('hidden', true);
          $(elements[element]).empty();
        }
        showFailToast_SubmitPAL();
        var errors = data['responseJSON'].errors;

        for (var key in errors) {
          switch (key) {
            case 'patrol_date':
              var element = '#patrol-log-date';
              var label = '#patrol-date-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'start_time':
              var element = '#patrol-start-time';
              var label = '#patrol-start_time-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'end_time':
              var element = '#patrol-end-time';
              var label = '#patrol-end_time-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'details':
              var element = '#patrol-details';
              var label = '#patrol-details-error';
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

  (function($) {
    'use strict';

    if ($(".select2-patrol-type").length) {
      $('.select2-patrol-type').select2({
          minimumResultsForSearch: -1
      });
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