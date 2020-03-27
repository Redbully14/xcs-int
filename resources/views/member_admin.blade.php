<?php $page_name = 'member_admin' ?>

@extends('master.app')

@section('customcss')

@endsection

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Member Settings </h3>
    <nav aria-label="breadcrumb">
      <a class="nav-link btn btn-success create-new-button" data-toggle="modal" aria-expanded="false" href="#" data-target="#memberAddModal">+ Add a Member</a>
    </nav>
  </div>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Member Settings</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive" id="usersTable">
            <table id="tableElement" class="table table-bordered">
              <thead>
                <tr>
                  <th>Antelope ID</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Website ID</th>
                  <th>Antelope Access</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('pluginjs')
<script src="/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
@endsection

@section('injectjs')
<script type="text/javascript">
  var $constants_access = @json($constants['role']);
  var $constants_status_text = @json($constants['antelope_status_text']);
  var $constants_status_color = @json($constants['antelope_status_color']);
</script>
<script src="/js/member_admin.js"></script>
@endsection

@section('modals')
  @include('modals.add_member_action_modal')
  @include('modals.edit_profile_modal')
@endsection