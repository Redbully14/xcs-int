var elements = {
  '#profile-name-field' : '#edit-name-error',
  '#profile-website-id-field' : '#edit-website_id-error',
  '#profile-username-field' : '#edit-username-error'
};

showFailToast_EditSuperAdmin = function() {
  'use strict';
  $.toast({
    heading: 'Profile Protected!',
    text: 'You are not allowed to edit other superadmins.',
    showHideTransition: 'slide',
    icon: 'error',
    loaderBg: '#f2a654',
    position: 'top-right'
  })
};

// TODO: Implement case not on member_admin
// Future self here: what the fuck did I mean by that?
$table = $('#tableElement');
$table.on('click', '#ajax_open_modal_edit', function () {
  for (var element in elements) {
    $(element).parent().removeClass('has-danger');
    $(element).removeClass('form-control-danger');
    $(elements[element]).prop('hidden', true);
    $(elements[element]).empty();
  }
  var isSuperAdmin = false;
  var id = $(this).val();
  $('#ajax_edit_member_save').val(id).change();

    $.ajax({
       type: "POST",
       url: $url_edit_profile_save_modal+id,
       success: function(data){
          var role = data.roles.map(function(dt) {
            return dt.slug;
          });
         console.log(data);
         if (role == "superadmin") {
            return false;
         } else {
           if(data['department_id'] == null) {
              var name_unitnumber = data['name'];
           } else var name_unitnumber = data['name']+' '+data['department_id'];
           $("#profile-display-name").text(name_unitnumber);
           $("#profile-name-field").val(data['name']);
           $("#profile-website-id-field").val(data['website_id']);
           $("#profile-department-id-field").val(data['department_id']);
           $("#profile-rank-field").val(data['rank']).change();
           $("#profile-active-field").prop('checked', data['antelope_status']);
           $("#profile-training-field").prop('checked', data['advanced_training']);
           $("#profile-exempt-field").prop('checked', data['requirements_exempt']);
           $("#profile-role-field").val(role).change();
           $("#profile-username-field").val(data['username']);
         }
       }
    }).done(function(data) {
      var role = data.roles.map(function(dt) {
        return dt.slug;
      });
      if(role == 'superadmin') {
        showFailToast_EditSuperAdmin();
      } 
      else $("#editProfileModal").modal("toggle");
    });
});

$( "#ajax_open_modal_edit_button" ).click(function() {
  for (var element in elements) {
    $(element).parent().removeClass('has-danger');
    $(element).removeClass('form-control-danger');
    $(elements[element]).prop('hidden', true);
    $(elements[element]).empty();
  }
  var isSuperAdmin = false;
  var id = $(this).val();
  $('#ajax_edit_member_save').val(id).change();

    $.ajax({
       type: "POST",
       url: $url_edit_profile_open_modal+id,
       success: function(data){
          var role = data.roles.map(function(dt) {
            return dt.slug;
          });
         console.log(data);
         if (role == "superadmin") {
            return false;
         } else {
           if(data['department_id'] == null) {
              var name_unitnumber = data['name'];
           } else var name_unitnumber = data['name']+' '+data['department_id'];
           $("#profile-display-name").text(name_unitnumber);
           $("#profile-name-field").val(data['name']);
           $("#profile-website-id-field").val(data['website_id']);
           $("#profile-department-id-field").val(data['department_id']);
           $("#profile-rank-field").val(data['rank']).change();
           $("#profile-active-field").prop('checked', data['antelope_status']);
           $("#profile-training-field").prop('checked', data['advanced_training']);
           $("#profile-exempt-field").prop('checked', data['requirements_exempt']);
           $("#profile-role-field").val(role).change();
           $("#profile-username-field").val(data['username']);
         }
       }
    }).done(function(data) {
      var role = data.roles.map(function(dt) {
        return dt.slug;
      });
      if(role == 'superadmin') {
        showFailToast_EditSuperAdmin();
      } else $("#editProfileModal").modal("toggle");
    });
});

showSuccessToast_EditMember = function() {
  'use strict';
  $.toast({
    heading: 'Profile Edited!',
    text: 'This profile has been edited and the new data has been sent to the database!',
    showHideTransition: 'slide',
    icon: 'success',
    loaderBg: '#f96868',
    position: 'top-right'
  })
};

showFailToast_EditMember = function() {
  'use strict';
  $.toast({
    heading: 'Profile Edit Failed!',
    text: 'Profile Edit failed, double check the fields to make sure that nothing is missing and that the website ID is not taken.',
    showHideTransition: 'slide',
    icon: 'error',
    loaderBg: '#f2a654',
    position: 'top-right'
  })
};