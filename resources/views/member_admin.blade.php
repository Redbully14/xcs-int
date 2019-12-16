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
                  <th>Rank</th>
                  <th>Antelope Access</th>
                  <th>Status</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Adding a Member - Modal -->

<div class="modal fade" id="memberAddModal" tabindex="-1" role="dialog" aria-labelledby="memberAddModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="memberAddModalLabel">Adding a Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="ajax_member_admin">
          <div class="modal-body">

            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control p_input" require id="name" name="name" autocomplete="name" autofocus>
            </div>

            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control p_input" require id="username" name="username" autocomplete="username" >
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control p_input" require id="password" name="password" autocomplete="new-password">
            </div>

            <div class="form-group">
              <label>Antelope Permission Level</label>
              <select class="js-example-basic-single" style="width:100%" id="access" name="access">
                @foreach($constants['access'] as $item => $value)
                  <option value="{{ $item }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Rank</label>
              <select class="js-example-basic-single" style="width:100%" id="rank" name="rank">
                @foreach($constants['rank'] as $rank => $value)
                  <option value="{{ $rank }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelAddMember">Cancel</button>
          </div>
      </form>
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

  $('#ajax_member_admin').on('submit', function(e) {
    e.preventDefault();
    var name = $('#name').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var access = $('#access').val();
    var rank = $('#rank').val();

    $.ajax({
      type: 'POST',
      url: '{{ url('member_admin/new') }}',
      data: {name:name, username:username, password:password, access:access, rank:rank},
      success: function() {
        showSuccessToast();
        $('#cancelAddMember').click();
        $('#usersTable').load(document.URL +  ' #usersTable');
      }
    });
  });

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
  $(function() {
     $('#tableElement').DataTable({
     serverSide: true,
     ajax: '{{ url('member_admin/get_users') }}',
     columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'username', name: 'username' },
      // the fucking part below was made thanks to stackoverflow
      // fucking <th>
      { data: 'rank', name: 'rank', render: function (data, type, row) {
          return constants_ranks[data];
        } 
      },
      { data: 'access', name: 'access', render: function (data, type, row) {
          try {
             if(constants_access[data] == null) throw "Antelope Developer"; 
             else return constants_access[data];
          } 
          catch(e) {
            return e;
          } 
        } 
      },
      { data: 'antelope_status', name: 'antelope_status', render: function (data, type, row) {
          return '<div class="badge badge-outline-'+constants_status_color[data]+' badge">'+constants_status_text[data]+'</div>';
        } 
      },
     ]
    });
  });
</script>
@endsection