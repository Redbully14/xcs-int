<!-- Submitting Website Feedback - Modal -->
<!-- Open modal with button id #feedback_modal-open -->
<div class="modal fade" id="feedback_modal" tabindex="-1" role="dialog" aria-labelledby="feedback_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Submit Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="feedback_modal-form">
          <div class="modal-body">

            <div class="form-group">
              <p><b>This project originally started out with one person having fun, now it has grown into a full-blown web application. Our development team has worked tiredlessly to make this application into reality and we would like to hear your feedback.<br>
              <br>
              Please fill this out as honest as possible, we want to hear your opinion on the application as a whole and your experience with the application, your voice will bring changes to the application</b></p>
            </div>

            <div class="form-group">
              <h4>Rate AntelopePHP</h4>
              <div class="br-wrapper br-theme-bars-square">
                <select id="antelope-square" name="rating" autocomplete="off" style="display: none;" required>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
            </div>

            <hr>

            <div class="form-group">
              <label>Feedback</label>
              <textarea class="form-control" id="feedback_modal-feedback" rows="3"></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="feedback_modal-cancel">Cancel</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  var $url_submit_feedback = '{{ url('feedback/') }}';
</script>
<script src="/js/modals/feedback_modal.js"></script>
