<?php $page_name = 'account_settings' ?>

@extends('master.app')

@section('customcss')
@endsection

@section('content')
  <div class="content-wrapper" style="padding-left: 300px; padding-right: 300px;">
    <div class="page-header">
      <h3 class="page-title"> Account Settings </h3>
      <nav aria-label="breadcrumb">
      <a class="nav-link btn btn-primary" href="/notifications"><i class="mdi mdi-bell"></i> Notification Center</a>
      </nav>
    </div>
    <div class="row">
      <div class="col-12">
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

                <h5>Avatar</h5><br>

                <form id="ajax_change_avatar">
                  <div class="form-group">
                    <label>Select an Avatar</label>
                    <select class="select2-ajax_avatar_type" style="width:100%" id="ajax_change_avatar-type" name="ajax_change_avatar-type">
                      @foreach($constants['avatars'] as $item => $value)
                        <option value="{{ $item }}">{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success mr-2">Change Avatar</button>
                </form><hr>

                <h5>Timezone</h5><br>

                <form id="ajax_change_timezone">
                  <div class="form-group">
                    <label>Select your timezone</label>
                    <select class="antelope_global_select_single-noclear" style="width:100%" id="ajax_change_timezone-input">
                      @foreach (timezone_identifiers_list() as $timezone)
                      <option value="{{ $timezone }}"{{ $timezone == old('timezone', request()->user()->timezone) ? ' selected' : '' }}>{{ $timezone }}</option>
                      @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success mr-2">Change Timezone</button>
                </form>

          </div>
        </div>
      </div>
    </div>
   </div>
@endsection

@section('pluginjs')
@endsection

@section('injectjs')
<script type="text/javascript">
  var $change_avatar_type = '{{ Auth::user()->avatar }}';
</script>
<script src="/js/account_settings.js"></script>
@endsection