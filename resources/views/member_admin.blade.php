<?php $page_name = 'member_admin' ?>

@extends('master.app')

@section('customcss')
<link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
<link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
<link rel="stylesheet" href="/assets/vendors/jquery-toast-plugin/jquery.toast.min.css">
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
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
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="/assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
@endsection

@section('ajax')
<script text="text/javascript">
  var constants_ranks = @json($constants['rank']);
  var constants_access = @json($constants['access']);
  var constants_status_text = @json($constants['antelope_status_text']);
  var constants_status_color = @json($constants['antelope_status_color']);

  showSuccessToast = function() {
    'use strict';
    $.toast({
      heading: 'User Added!',
      text: 'New user has been added to the database, you are now able to view/edit the profile.',
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-right'
    })
  };

  showFailToast = function() {
    'use strict';
    $.toast({
      heading: 'User Adding Failed!',
      text: 'Adding user failed, double check if the civilian ID, Website ID or username fields are taken.',
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#f2a654',
      position: 'top-right'
    })
  };

  $(function() {
     $('#tableElement').DataTable({
     serverSide: true,
     ajax: '{{ url('member_admin/get_users') }}',
     columns: [
      { data: 'id', name: 'id', searchable: true },
      { data: 'name', name: 'name', searchable: true },
      { data: 'username', name: 'username', searchable: true },
      // the fucking part below was made thanks to stackoverflow
      // fucking <th>
      { data: 'access', name: 'access', searchable: true, render: function (data, type, row) {
          try {
             if(constants_access[data] == null) throw "Antelope Developer"; 
             else return constants_access[data];
          } 
          catch(e) {
            return e;
          } 
        } 
      },
      { data: 'antelope_status', searchable: false, name: 'antelope_status', render: function (data, type, row) {
          return '<div class="badge badge-outline-'+constants_status_color[data]+' badge-pill">'+constants_status_text[data]+'</div>';
        } 
      },
      // dude wtf is going on
      { data: 'id', searchable: false, render: function(data, type, row) { return '<button id="ajax_open_modal_edit" value="'+data+'">Edit</button>'; } },
     ]
    });
  });
</script>
@endsection

@section('modals')
  @include('modals.add_member_action_modal')
  @include('modals.edit_profile_modal')
@endsection