<!-- Edit a Profile - Modal -->
<!-- Open modal with button id #ajax_open_modal_edit -->

<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="ajax_edit_member">
          <div class="modal-body">

            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h2 class="card-title" id="profile-display-name">ajax-profile-display-name</h2>
                    <h5 class="card-title">General Data</h5>

                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control p_input" require id="profile-name-field" name="name" autocomplete="name" autofocus value="ajax-profile-display-input-name">
                    </div>

                    <div class="form-group">
                      <label>Website ID</label>
                      <input type="text" class="form-control p_input" require id="profile-website-id-field" name="website-id" value="ajax-profile-display-input-website-id">
                    </div>

                    <div class="form-group">
                      <label>{{ 'Civilian ID -- changeme' }}</label>
                      <input type="text" class="form-control p_input" require id="profile-department-id-field" name="department-id" value="ajax-profile-display-input-department-id">
                    </div>

                    <div class="form-group">
                      <label>Rank</label>
                      <select class="js-example-basic-single" style="width:100%" id="profile-rank-field" name="rank">
                        @foreach($constants['rank'] as $rank => $value)
                          <option value="{{ $rank }}">{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Profile Settings</label>
                      <div class="form-check form-check-success">
                        <label class="form-check-label"><input type="checkbox" class="form-check-input" checked=""> Active Profile <i class="input-helper"></i></label>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">Statistics or something</h4>
                      <p class="text-muted mb-1">Your data status</p>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="preview-list">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelAddMember">Cancel</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#ajax_edit_member').on('submit', function(e) {
    e.preventDefault();
  });

  $('#ajax_open_modal_edit').on('click', function(e) {
    var id = $(this).val();
      $.ajax({
         type: "POST",
         url: '{{ url('member/edit/get_data/') }}/'+id,
         success: function(data){
           console.log(data);
             if(data['department_id'] == null) {
                var name_unitnumber = data['name'];
             } else var name_unitnumber = data['name']+' '+data['department_id'];

             $("#profile-display-name").text(name_unitnumber);
             $("#profile-name-field").val(data['name']);
             $("#profile-website-id-field").val(data['website_id']);
             $("#profile-department-id-field").val(data['department_id']);
             $("#profile-rank-field").val(data['rank']).change();
         }
      });

    $("#editProfileModal").modal("toggle");
  });

  (function($) {
    'use strict';

    if ($(".js-example-basic-single").length) {
      $(".js-example-basic-single").select2();
    }
    if ($(".js-example-basic-multiple").length) {
      $(".js-example-basic-multiple").select2();
    }
  })(jQuery);
</script>