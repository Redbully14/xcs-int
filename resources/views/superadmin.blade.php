<?php $page_name = 'superadmin' ?>

@extends('master.app')

@section('customcss')
@endsection

@section('content')
<div class="content-wrapper">
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
                  <button type="submit" class="btn btn-danger mr-2">Change Password</button>
                </form><hr>
          </div>
        </div>
      </div>
	</div>
</div>
@endsection

@section('pluginjs')
@endsection