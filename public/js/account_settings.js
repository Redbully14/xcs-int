showSuccessToast_ChangePassword = function() {
  'use strict';
  $.toast({
    heading: 'Password Changed!',
    text: 'Your password has now been changed.',
    showHideTransition: 'slide',
    icon: 'success',
    loaderBg: '#f96868',
    position: 'top-right'
  })
};

showFailToast_ChangePassword = function() {
  'use strict';
  $.toast({
    heading: 'Password Change Failed!',
    text: 'Your password could not be changed, recheck all the fields and ensure everything is correct.',
    showHideTransition: 'slide',
    icon: 'error',
    loaderBg: '#f2a654',
    position: 'top-right'
  })
};

$('#ajax_change_password').on('submit', function(e) {
  e.preventDefault();
  var current_password = $('#ajax_change_password-current_password').val();
  var new_password = $('#ajax_change_password-new_password').val();
  var new_confirm_password = $('#ajax_change_password-confirm_new_password').val();
  var elements = {
    '#ajax_change_password-current_password' : '#ajax_change_password-current_password-error',
    '#ajax_change_password-new_password' : '#ajax_change_password-new_password-error',
    '#ajax_change_password-confirm_new_password' : '#ajax_change_password-current_password-error',
  };

  for (var element in elements) {
    $(element).parent().removeClass('has-danger');
    $(element).removeClass('form-control-danger');
    $(elements[element]).prop('hidden', true);
    $(element).val('');
    $(elements[element]).empty();
  }

  $.ajax({
    type: 'POST',
    url: baseURL + '/settings/change_password/',
    data: {current_password:current_password, new_password:new_password, new_confirm_password:new_confirm_password},
    success: function() {
      showSuccessToast_ChangePassword();
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
      showFailToast_ChangePassword();
      var errors = data['responseJSON'].errors;

      for (var key in errors) {
        switch (key) {
          case 'current_password':
            var element = '#ajax_change_password-current_password';
            var label = '#ajax_change_password-current_password-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'new_password':
            var element = '#ajax_change_password-new_password';
            var label = '#ajax_change_password-new_password-error';
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
            $(label).append(errors[key]);
            $(label).prop('hidden', false);
          break;
          case 'confirm_new_password':
            var element = '#ajax_change_password-confirm_new_password';
            var label = '#ajax_change_password-confirm_new_password-error';
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

$('#ajax_change_avatar').on('submit', function(e) {
  e.preventDefault();
  var avatar = $('#ajax_change_avatar-type').val();

  $.ajax({
    type: 'POST',
    url: baseURL + '/settings/change_avatar/',
    data: {avatar:avatar},
    success: function() {
      var toast_heading = "Avatar Changed!";
      var toast_text = "Your avatar has been changed, reload the page for the changes to take effect!";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    },
    error: function(data) {
      var toast_heading = "Avatar Error!";
      var toast_text = "Your avatar could not be changed, contact a member of the CoC with this error!";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    }
  });
});

$('#ajax_change_timezone').on('submit', function(e) {
  e.preventDefault();
  var timezone = $('#ajax_change_timezone-input').val();

  $.ajax({
    type: 'POST',
    url: baseURL + '/settings/change_timezone/',
    data: {timezone:timezone},
    success: function() {
      var toast_heading = "Timezone Changed!";
      var toast_text = "Your timezone has been changed!";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    },
    error: function(data) {
      var toast_heading = "Timezone Error!";
      var toast_text = "Your timezone could not be changed, contact a member of the CoC with this error!";
      var toast_icon = "error";
      var toast_color = "#f2a654";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    }
  });
});

$("document").ready(function() {
    $('#ajax_change_avatar-type').val($change_avatar_type).change();
});

(function($) {
  'use strict';

  if ($(".select2-ajax_avatar_type").length) {
    $('.select2-ajax_avatar_type').select2({
        minimumResultsForSearch: -1
    });
  }
})(jQuery);