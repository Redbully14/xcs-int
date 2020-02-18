@if(Auth::user()->level() >= $constants['access_level']['staff'])
<!-- Edit Flag - Modal -->
<!-- Open modal with button (IN TABLE) id #ajax_open_modal_edit -->
<!-- Open modal with button (ON PAGE) id #ajax_open_modal_edit_button -->
<div class="modal fade" id="ajax_edit_flags" tabindex="-1" role="dialog" aria-labelledby="ajax_edit_flags" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Patrol Log Flags</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ajax_edit_member">
                <div class="modal-body">

                    <div class="form-group">
                        <h5>Flag Details</h5>
                        <label>Self Flag: <span id="ajax-span-self-flag-viewer"></span></label>
                        <textarea class="form-control" id="ajax-textarea-self-flag-viewer" rows="6" placeholder="No details." disabled></textarea>
                        <br>
                        <label>Automatic Flag: <span id="ajax-span-auto-flag-viewer"></span></label>
                        <textarea class="form-control" id="ajax-textarea-auto-flag-viewer" rows="6" placeholder="No details." disabled></textarea>
                    </div>

                    <hr style="border-top: 1px solid rgba(255, 255, 255, 1.0);">

                    <h5>Resolve Flags</h5>

                    <div class="form-group">
                        <div class="form-check form-check-info">
                            <label class="form-check-label"><input type="checkbox" id="resolve-self-flag"> Mark Self Flag Resolved</label>
                            <label id="resolve-self-flag-error" class="error mt-2 text-danger" for="resolve-self-flag" hidden></label>
                        </div>
                        <textarea id="resolve-self-flag-details" class="form-control" style="display: none" rows="6" placeholder="Enter an optional note here..."></textarea>
                        <label id="resolve-self-flag-details-error" class="error mt-2 text-danger" for="resolve-self-flag-details" hidden></label>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-check-info">
                            <label class="form-check-label"><input type="checkbox" id="resolve-auto-flag"> Mark Automatic Flag Resolved</label>
                            <label id="resolve-auto-flag-error" class="error mt-2 text-danger" for="resolve-auto-flag" hidden></label>
                        </div>
                        <textarea id="resolve-auto-flag-details" class="form-control" style="display: none" rows="6" placeholder="Enter an optional note here..."></textarea>
                        <label id="resolve-auto-flag-details-error" class="error mt-2 text-danger" for="resolve-auto-flag-details" hidden></label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="save_flags" value="0" type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal" id="ajax_edit_flags_cancel">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var $url_edit_flags = '{{ url('activity/get_flag_data/') }}/';
    var $url_edit_flags_POST = '{{ url('activity/edit_flag_data/') }}/';
</script>
<script src="/js/modals/edit_flags_modal.js"></script>

@endif
