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

function changePasswordPopup() {
    let modalNode = $('div[tabindex*="-1"]')
    if (!modalNode) return;

    modalNode.removeAttr('tabindex');
    modalNode.addClass('js-swal-fixed');

    swal({
        title: 'Are you sure?',
        text: "The password you enter here will be a temporary password, one that you can provide to the user to use to sign in. After they have used this password, they will be forced to set a new password before being allowed to continue.",
        icon: 'warning',
        content: {
          element: "input",
          attributes: {
            placeholder: "Type a new password here",
            type: "text",
            class: 'form-control'
          },
        },
        buttons: {
          confirm: {
            text: "Change Password",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true
          },
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          }
        }
    }).then(newPassword => {
        let modalNode = $('.js-swal-fixed')
        if (!modalNode) return;

        modalNode.attr('tabindex', '-1');
        modalNode.removeClass('js-swal-fixed');

        if(newPassword.length < 7) {
            return swal("Password too short! Temporary passwords need to be at least 8 characters long.", {
                icon: "error"
            });
        }

        swal.close();

        $.ajax({
            type: 'POST',
            url: $url_edit_profile_password_modal_POST + $('#ajax_edit_member_save').val(),
            data: {new_password: newPassword},
            success: function() {
                showSuccessToast_EditMember();
                if ($('#tableElement').length) {
                    $('#tableElement').DataTable().ajax.reload();
                }
            },
        });
    })
}

function deleteUserPopup() {
  let modalNode = $('div[tabindex*="-1"]')
  if (!modalNode) return;

  modalNode.removeAttr('tabindex');
  modalNode.addClass('js-swal-fixed');

  swal({
      title: 'Are you sure?',
      text: "This is a destructive method, do you really wish to delete this account? Only Antelope Developers are able to restore accounts.",
      icon: 'warning',
      buttons: {
        confirm: {
          text: "Delete Account",
          value: true,
          visible: true,
          className: "btn btn-danger",
          closeModal: true
        },
        cancel: {
          text: "Cancel",
          value: null,
          visible: true,
          className: "btn btn-primary",
          closeModal: true,
        }
      }
  }).then( function(isConfirm) {
    if(isConfirm) {
      $.ajax({
          type: 'POST',
          url: $url_edit_profile_delete_modal_POST + $('#ajax_edit_member_save').val(),
          success: function() {
              var toast_heading = "Member Deleted!";
              var toast_text = "This member has been fully deleted from our database.";
              var toast_icon = "success";
              var toast_color = "#f96868";
              globalToast(toast_heading, toast_text, toast_icon, toast_color);
              $('#cancelEditMember').click();
              if ($('#tableElement').length) {
                  $('#tableElement').DataTable().ajax.reload();
              }
          },
      });
    }
  })
}