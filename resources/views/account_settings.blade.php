<?php $page_name = 'account_settings' ?>

@extends('master.app')

@section('customcss')
@endsection

@section('content')
  <div class="content-wrapper" style="padding-left: 300px; padding-right: 300px;">
    <div class="page-header">
      <h3 class="page-title"> Account Settings </h3>
    </div>
    <div class="row">
      <div class="col-12">
      	@if( \Session::get('temp_password_required') )
            <div class="alert alert-warning" role="alert"><i class="mdi mdi-alert-circle"></i> The account currently has a temporary password, you are required to change it in order to use Antelope. </div>
        @endif
        <div class="card">
          <div class="card-body">

              	<h5>Change Password</h5><br>

				<form id="ajax_change_password">
                  <div class="form-group">
                    <label for="ajax_change_password-current_password">Current Password</label>
                    <input type="password" class="form-control" id="ajax_change_password-current_password" placeholder="Password">
                    <label id="ajax_change_password-current_password-error" class="error mt-2 text-danger" for="ajax_change_password-current_password" hidden></label>
                  </div>
                  <div class="form-group">
                    <label for="ajax_change_password-new_password">New Password</label>
                    <input type="password" class="form-control" id="ajax_change_password-new_password" placeholder="Password">
                    <label id="ajax_change_password-new_password-error" class="error mt-2 text-danger" for="ajax_change_password-new_password" hidden></label>
                  </div>
                  <div class="form-group">
                    <label for="ajax_change_password-confirm_new_password">Confirm New Password</label>
                    <input type="password" class="form-control" id="ajax_change_password-confirm_new_password" placeholder="Password">
                   	<label id="ajax_change_password-confirm_new_password-error" class="error mt-2 text-danger" for="ajax_change_password-confirm_new_password" hidden></label>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2">Change Password</button>
                </form>

          </div>
        </div>
      </div>
    </div>
   </div>
@endsection

@section('pluginjs')
@endsection

@section('ajax')
<script type="text/javascript">
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
      url: '{{ url('settings/change_password') }}',
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
@endsection