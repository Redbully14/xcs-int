@if(Auth::user()->level() >= $constants['access_level']['staff'])
<!-- Edit a Profile - Modal -->
<!-- Open modal with button (IN TABLE) id #ajax_open_modal_edit -->
<!-- Open modal with button (ON PAGE) id #ajax_open_modal_edit_button -->

<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="padding-left: 300px; padding-right: 300px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Profile Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
        <form id="ajax_edit_member">
        @endif
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h2 class="card-title" id="profile-display-name">ajax-profile-display-name</h2>
                    <h5 class="card-title">General Data</h5>

                    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control p_input" id="profile-name-field" name="name" autocomplete="name" autofocus value="ajax-profile-display-input-name">
                      <label id="edit-name-error" class="error mt-2 text-danger" for="profile-name-field" hidden></label>
                    </div>
                    @else
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control p_input" require id="profile-name-field" name="name" autocomplete="name" disabled value="ajax-profile-display-input-name">
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
                    <div class="form-group">
                      <label>Website ID</label>
                      <input type="text" class="form-control p_input" require id="profile-website-id-field" name="website-id" value="ajax-profile-display-input-website-id">
                      <label id="edit-website_id-error" class="error mt-2 text-danger" for="profile-website-id-field" hidden></label>
                    </div>
                    @else
                    <div class="form-group">
                      <label>Website ID</label>
                      <input type="text" class="form-control p_input" disabled id="profile-website-id-field" name="website-id" value="ajax-profile-display-input-website-id">
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
                    <div class="form-group">
                      <label>{{ $constants['department']['department_callsign'] }} (optional)</label>
                      <input type="text" class="form-control p_input" require id="profile-department-id-field" name="department-id" value="ajax-profile-display-input-department-id">
                      <label id="edit-department_id-error" class="error mt-2 text-danger" for="profile-department-id-field" hidden></label>
                    </div>
                    @else
                    <div class="form-group">
                      <label>{{ $constants['department']['department_callsign'] }}</label>
                      <input type="text" class="form-control p_input" disabled id="profile-department-id-field" name="department-id" value="ajax-profile-display-input-department-id">
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
                    <div class="form-group">
                      <label>Rank</label>
                      <select class="antelope_global_select_single-noclear" style="width:100%" id="profile-rank-field" name="rank">
                        @foreach($constants['rank'] as $rank => $value)
                          <option value="{{ $rank }}">{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    @else
                    <div class="form-group">
                      <label>Rank</label>
                      <select class="antelope_global_select_single-noclear" style="width:100%" id="profile-rank-field" name="rank" disabled>
                        @foreach($constants['rank'] as $rank => $value)
                          <option value="{{ $rank }}">{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['admin'])
                    <div class="form-group">
                      <label>Profile Settings</label>
                      <div class="form-check form-check-info">
                        <label class="form-check-label"><input type="checkbox" class="profile-active-field" id="profile-active-field"> Profile Activated <i class="input-helper"></i></label>
                      </div>
                    </div>
                    @else
                    <div class="form-group">
                      <label>Profile Settings</label>
                      <div class="form-check form-check-info" hidden>
                        <label class="form-check-label"><input type="checkbox" class="profile-active-field" id="profile-active-field" disabled> Profile Activated <i class="input-helper"></i></label>
                      </div>
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
                    <div class="form-group">
                      <div class="form-check form-check-info">
                        <label class="form-check-label"><input type="checkbox" class="profile-exempt-field" id="profile-exempt-field"> Exempt from Requirements <i class="input-helper"></i></label>
                      </div>
                    </div>
                    @else
                    <div class="form-group">
                      <div class="form-check form-check-info">
                        <label class="form-check-label"><input type="checkbox" class="profile-exempt-field" id="profile-exempt-field" disabled> Exempt from Requirements <i class="input-helper"></i></label>
                      </div>
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
                    <div class="form-group">
                      <div class="form-check form-check-info">
                        <label class="form-check-label"><input type="checkbox" class="profile-training-field" id="profile-training-field"> Advanced Training <i class="input-helper"></i></label>
                      </div>
                    </div>
                    @else
                    <div class="form-group">
                      <div class="form-check form-check-info">
                        <label class="form-check-label"><input type="checkbox" class="profile-training-field" id="profile-training-field" disabled> Advanced Training <i class="input-helper"></i></label>
                      </div>
                    </div>
                    @endif

                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Antelope Data</h5>

                    @if(Auth::user()->level() >= $constants['access_level']['admin'])
                    <div class="form-group">
                      <label>Antelope Username</label>
                      <input type="text" class="form-control p_input" id="profile-username-field" name="username" autocomplete="username" autofocus value="ajax-profile-display-input-username">
                      <label id="edit-username-error" class="error mt-2 text-danger" for="profile-username-field" hidden></label>
                    </div>
                    @else
                    <div class="form-group" hidden>
                      <label hidden>Antelope Username</label>
                      <input type="text" class="form-control p_input" id="profile-username-field" name="username" autocomplete="username" autofocus value="ajax-profile-display-input-username" disabled hidden>
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['admin'])
                    <div class="form-group">
                      <label>Antelope Access</label>
                      <select hidden class="js-example-basic-single" style="width:100%" id="profile-role-field" name="role">
                        @foreach($constants['role'] as $role => $value)
                          @if (!$loop->first)
                          <option hidden value="{{ $role }}">{{ $value }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    @else
                    <div class="form-group">
                      <label>Antelope Access</label>
                      <select class="js-example-basic-single" style="width:100%" id="profile-role-field" name="role" disabled>
                        @foreach($constants['role'] as $role => $value)
                          <option value="{{ $role }}">{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['admin'])
                    <div class="form-group">
                      <label>Antelope Password</label>
                      <button type="button" class="form-control btn btn-outline-warning btn-fw" onclick="changePasswordPopup()">Change User Password</button>
                    </div>
                    @endif

                    @if(Auth::user()->level() >= $constants['access_level']['admin'])
                    <div class="form-group">
                      <label>Delete Account</label>
                      <button type="button" class="form-control btn btn-outline-danger btn-fw" onclick="deleteUserPopup()">Delete User Account</button>
                    </div>
                    @endif

                  </div>
                </div>
              </div>
            </div>

          <div class="modal-footer">
            @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
            <button type="submit" class="btn btn-success" id="ajax_edit_member_save" value="0">Save</button>
            @endif
            <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelEditMember">Cancel</button>
          </div>
      @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
      </form>
      @endif
    </div>
  </div>
</div>
</div>
</div>

<script type="text/javascript">
  var $url_getUsersActivity_fn = '{{ url('activity/get_profile_logs/') }}/';
  var $getUsersActivity_fn_constant = '{{ $constants['global_id']['patrol_log'] }}';
  var $url_edit_profile_save_modal = '{{ url('member/edit/get_data/') }}/';
  var $url_edit_profile_open_modal = '{{ url('member/edit/get_data/') }}/';
</script>
<script src="/js/modals/edit_profile_modal_FETCH.js"></script>

@if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
<script type="text/javascript">
  var $url_edit_profile_modal_POST = '{{ url('member/edit/edit_user/') }}/';
  var $url_edit_profile_password_modal_POST = '{{ url('member/edit/edit_user_password/') }}/';
  var $url_edit_profile_delete_modal_POST = '{{ url('member_admin/delete/') }}/';
</script>
<script src="/js/modals/edit_profile_modal_EDIT.js"></script>
@endif

@endif
