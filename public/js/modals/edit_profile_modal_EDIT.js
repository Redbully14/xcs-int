$('#ajax_edit_member').on('submit', function(e) {
  e.preventDefault();
  var id = $('#ajax_edit_member_save').val();
  var name = $('#profile-name-field').val();
  var website_id = $('#profile-website-id-field').val();
  var department_id = $('#profile-department-id-field').val();
  var rank = $('#profile-rank-field').val();
  var antelope_status = $("#profile-active-field").prop("checked") ? 1 : 0;
  var username = $('#profile-username-field').val();
  var role = $('#profile-role-field').val();
  var advanced_training = $("#profile-training-field").prop("checked") ? 1 : 0;
  var requirements_exempt = $("#profile-exempt-field").prop("checked") ? 1 : 0;

  $.ajax({
    type: 'POST',
    url: $url_edit_profile_modal_POST + id,
    data: {name:name, website_id:website_id, department_id:department_id, rank:rank, antelope_status:antelope_status, username:username, role:role, advanced_training:advanced_training, requirements_exempt:requirements_exempt},
    success: function() {
        for (var element in elements) {
          $(element).parent().removeClass('has-danger');
          $(element).removeClass('form-control-danger');
          $(elements[element]).prop('hidden', true);
          $(elements[element]).empty();
        }
        showSuccessToast_EditMember();
        if ($('#tableElement').length) {
          $('#tableElement').DataTable().ajax.reload();
        }
      },
    error: function(data) {
      for (var element in elements) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
        $(elements[element]).prop('hidden', true);
        $(elements[element]).empty();
      }
      showFailToast_EditMember();
      var errors = data['responseJSON'].errors;
      console.log(errors);

      for (var key in errors) {
        switch (key) {
          case 'name':
            var element = '#profile-name-field';
            var label = '#edit-name-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'website_id':
            var element = '#profile-website-id-field';
            var label = '#edit-website_id-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'username':
            var element = '#profile-username-field';
            var label = '#edit-username-error';
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