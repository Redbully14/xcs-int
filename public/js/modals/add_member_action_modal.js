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
    url: $url_add_member_modal,
    data: {name:name, username:username, password:password, role:role, rank:rank, website_id:website_id, department_id:department_id},
    success: function() {
      var toast_heading = "User Added!";
      var toast_text = "New user has been added to the database, you are now able to view/edit the profile.";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
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
      var toast_heading = "User Adding Failed!";
      var toast_text = "Adding user failed, double check if the civilian ID, Website ID or username fields are taken.";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
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