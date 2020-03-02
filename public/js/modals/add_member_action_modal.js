$('#add_member_clipboard').on('click', function(e) {
  let modalNode = $('div[tabindex*="-1"]')
  if (!modalNode) return;

  modalNode.removeAttr('tabindex');
  modalNode.addClass('js-swal-fixed');

  swal({
      title: 'Create a Member',
      text: "To create a member simply copy and paste the entire line from the community roster and the data will be extracted and processed here.",
      icon: 'info',
      content: {
        element: "input",
        attributes: {
          placeholder: "Copy and paste the entire line from the community roster",
          type: "text",
          class: 'form-control'
        },
      },
      buttons: {
        confirm: {
          text: "Create Member",
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
  }).then(newMember => {
      let modalNode = $('.js-swal-fixed')
      if (!modalNode) return;

      modalNode.attr('tabindex', '-1');
      modalNode.removeClass('js-swal-fixed');

      swal.close();

      var direm = newMember.split("\t");

      var rank = direm[1];
      var department_id = direm[2];
      var name = direm[3];
      var website_id = direm[6];

      // safety check
      if (direm[0] == "Active" || direm[0] == "Update Roster") {
        $.ajax({
          type: 'POST',
          url: $url_clipboard_url,
          data: {rank:rank, department_id:department_id, name:name, website_id:website_id},
          success: function(data) {
            memberCreatedSwal(data);
            $('#cancelAddMember').click();
          },
          error: function() {
            var toast_heading = "User Adding Failed!";
            var toast_text = "Ensure you are copying the entire row when adding the user!";
            var toast_icon = "error";
            var toast_color = "#f2a654";
            globalToast(toast_heading, toast_text, toast_icon, toast_color);
          }
        });
      } else {
        var toast_heading = "User Adding Failed!";
        var toast_text = "Ensure you are copying the entire row when adding the user!";
        var toast_icon = "error";
        var toast_color = "#f2a654";
        globalToast(toast_heading, toast_text, toast_icon, toast_color);
      }

  })
});

memberCreatedSwal = function(data) {
  console.log(data);

  swal({
      title: 'Member Created',
      text: "The member has been created, copy and paste the following information to them.",
      icon: 'success',
      closeOnClickOutside: false,
      html: true,
      content: {
        element: "textarea",
        attributes: {
          value: "This login information is used to access the Civilian Operations Digital System where you will be logging all of your patrol logs and will have access to all of your information.\n\nWebsite: "+$base_url+"\nUsername: "+data['username']+"\nPassword: "+data['password'],
          rows: "6",
          disabled: "disabled",
        },
      },
      buttons: {
        cancel: {
          text: "Close",
          value: null,
          visible: true,
          className: "btn btn-danger",
          closeModal: true,
        }
      }
  })
};

$('#add_generate_username').on('click', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'GET',
    url: $url_generate_username,
    success: function(data) {
      $('#username').val(data);
    },
  });
});

$('#add_generate_password').on('click', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'GET',
    url: $url_generate_password,
    success: function(data) {
      $('#password').val(data);
    },
  });
});


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
    success: function(data) {
      memberCreatedSwal(data);
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