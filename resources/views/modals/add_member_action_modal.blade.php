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
              <label>Name (required)</label>
              <input type="text" class="form-control p_input" require id="name" name="name" autocomplete="name" autofocus>
              <label id="add-name-error" class="error mt-2 text-danger" for="name" hidden></label>
            </div>

            <div class="form-group">
              <label>Username (required)</label>
              <input type="text" class="form-control p_input" require id="username" name="username" autocomplete="username" >
              <label id="add-username-error" class="error mt-2 text-danger" for="username" hidden></label>
            </div>

            <div class="form-group">
              <label>Temporary Password (required, minimum 8 characters)</label>
              <input type="password" class="form-control p_input" require id="password" name="password" autocomplete="new-password">
              <label id="add-password-error" class="error mt-2 text-danger" for="password" hidden></label>
            </div>

            <div class="form-group">
              <label>Website ID (required)</label>
              <input type="text" class="form-control p_input" require id="website_id" name="website_id">
              <label id="add-website_id-error" class="error mt-2 text-danger" for="website_id" hidden></label>
            </div>

            <div class="form-group">
              <label>{{ $constants['department']['department_callsign'] }} (optional)</label>
              <input type="text" class="form-control p_input" require id="department_id" name="department_id">
              <label id="add-department_id-error" class="error mt-2 text-danger" for="department_id" hidden></label>
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
    var elements = {
      '#name' : '#add-name-error',
      '#website_id' : '#add-website_id-error',
      '#username' : '#add-username-error',
      '#department_id' : '#add-departmnet_id-error',
      '#password' : '#add-password-error',
    };

    // this is really crappy but i just can't be asked anymore
    for (var element in elements) {
      $(element).parent().removeClass('has-danger');
      $(element).removeClass('form-control-danger');
      $(elements[element]).prop('hidden', true);
      $(element).val('');
      $(elements[element]).empty();
    }

    $.ajax({
      type: 'POST',
      url: '{{ url('member_admin/new') }}',
      data: {name:name, username:username, password:password, role:role, rank:rank, website_id:website_id, department_id:department_id},
      success: function() {
        showSuccessToast_AddMember();
        $('#cancelAddMember').click();
        $('#tableElement').DataTable().ajax.reload();
        for (var element in elements) {
          $(element).parent().removeClass('has-danger');
          $(element).removeClass('form-control-danger');
          $(elements[element]).prop('hidden', true);
          $(element).val('');
          $(elements[element]).empty();
        }
      },
      error: function(data) {
        for (var element in elements) {
          $(element).parent().removeClass('has-danger');
          $(element).removeClass('form-control-danger');
          $(elements[element]).prop('hidden', true);
          $(element).val('');
          $(elements[element]).empty();
        }
        showFailToast_AddMember();
        var errors = data['responseJSON'].errors;

        for (var key in errors) {
          switch (key) {
            case 'name':
              var element = '#name';
              var label = '#add-name-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'username':
              var element = '#username';
              var label = '#add-username-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'website_id':
              var element = '#website_id';
              var label = '#add-website_id-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'department_id':
              var element = '#department_id';
              var label = '#add-department_id-error';
              $(element).parent().addClass('has-danger');
              $(element).addClass('form-control-danger');
              $(label).append(errors[key]);
              $(label).prop('hidden', false);
            break;
            case 'password':
              var element = '#password';
              var label = '#add-password-error';
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

    if ($(".js-example-basic-single").length) {
      $(".js-example-basic-single").select2();
    }
    if ($(".js-example-basic-multiple").length) {
      $(".js-example-basic-multiple").select2();
    }
  })(jQuery);
</script>
@endif