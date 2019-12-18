@if(Auth::user()->level() >= $constants['access_level']['admin'])
<!-- Adding a Member - Modal -->
<div class="modal fade" id="memberAddModal" tabindex="-1" role="dialog" aria-labelledby="memberAddModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="memberAddModalLabel">Adding a Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="ajax_add_member">
          <div class="modal-body">

            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control p_input" require id="name" name="name" autocomplete="name" autofocus>
            </div>

            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control p_input" require id="username" name="username" autocomplete="username" >
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control p_input" require id="password" name="password" autocomplete="new-password">
            </div>

            <div class="form-group">
              <label>Website ID</label>
              <input type="text" class="form-control p_input" require id="website_id" name="website_id">
            </div>

            <div class="form-group">
              <label>{{ $constants['department']['department_callsign'] }}</label>
              <input type="text" class="form-control p_input" require id="department_id" name="department_id">
            </div>

            <div class="form-group">
              <label>Antelope Permission Level</label>
              <select class="js-example-basic-single" style="width:100%" id="role" name="role">
                @foreach($constants['role'] as $item => $value)
                  <option value="{{ $item }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Rank</label>
              <select class="js-example-basic-single" style="width:100%" id="rank" name="rank">
                @foreach($constants['rank'] as $rank => $value)
                  <option value="{{ $rank }}">{{ $value }}</option>
                @endforeach
              </select>
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
  showSuccessToast_AddMember = function() {
    'use strict';
    $.toast({
      heading: 'User Added!',
      text: 'New user has been added to the database, you are now able to view/edit the profile.',
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-right'
    })
  };

  showFailToast_AddMember = function() {
    'use strict';
    $.toast({
      heading: 'User Adding Failed!',
      text: 'Adding user failed, double check if the civilian ID, Website ID or username fields are taken.',
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#f2a654',
      position: 'top-right'
    })
  };

  $('#ajax_add_member').on('submit', function(e) {
    e.preventDefault();
    var name = $('#name').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var website_id = $('#website_id').val();
    var department_id = $('#department_id').val();
    var role = $('#role').val();
    var rank = $('#rank').val();

    $.ajax({
      type: 'POST',
      url: '{{ url('member_admin/new') }}',
      data: {name:name, username:username, password:password, role:role, rank:rank, website_id:website_id, department_id:department_id},
      success: function() {
        showSuccessToast_AddMember();
        $('#cancelAddMember').click();
        $('#tableElement').DataTable().ajax.reload();
      },
      error: function() {
        showFailToast_AddMember();
      }
    });
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
@endif