@extends('master.app')

@section('customcss')
<link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
<link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
<link rel="stylesheet" href="/assets/vendors/jquery-toast-plugin/jquery.toast.min.css">
@endsection

@section('content')
<div class="content-wrapper" style="padding-bottom: 650px;">
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
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                  <th>Antelope ID</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Rank</th>
                  <th>Access Level</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->username }}</td>
                  <td>{{ $ranks[$user->rank] }}</td>
                  <td>@php 
                    try {
                      echo $access[$user->access];
                    } catch (Exception $e) {
                      echo 'Antelope Developer';
                    };
                  @endphp</td>
                  <td>
                    <label class="badge badge-{{ $status_colors[$user->antelope_status] }}">{{ $status_text[$user->antelope_status] }}</label>
                  </td>
                  <td>
                    <button class="btn btn-outline-primary">Edit</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
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
                @foreach($access as $item => $value)
                  <option value="{{ $item }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Rank</label>
              <select class="js-example-basic-single" style="width:100%" id="rank" name="rank">
                @foreach($ranks as $rank => $value)
                  <option value="{{ $rank }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
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
@endsection

@section('ajax')
<script text="text/javascript">
  $('#ajax_member_admin').on('submit', function(e) {
    var name = $('#name').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var access = $('#access').val();
    var rank = $('#rank').val();

    $.ajax({
      type: 'POST',
      url: '{{ url('member_admin/new') }}',
      data: {name:name, username:username, password:password, access:access, rank:rank}
    });
  });
</script>
@endsection