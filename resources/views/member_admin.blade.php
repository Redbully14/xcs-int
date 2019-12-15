@extends('master.app')

@section('customcss')
<link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
<link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
@endsection

@section('content')
<div class="content-wrapper" style="padding-bottom: 650px;">
  <div class="page-header">
    <h3 class="page-title"> Data table </h3>
    <nav aria-label="breadcrumb">
      <a class="nav-link btn btn-success create-new-button" data-toggle="modal" aria-expanded="false" href="#" data-target="#memberAddModal">+ Add a Member</a>
    </nav>
  </div>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Data table</h4>
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
                  <td>{{ $user->rank }}</td>
                  <td>{{ $user->access }}</td>
                  <td>
                    <label class="badge badge-info">Test</label>
                  </td>
                  <td>
                    <button class="btn btn-outline-primary">View</button>
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
        <form method="POST" action="/member_admin/new">
          @csrf
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
@endsection

@section('customjs')
<script src="/assets/js/select2.js"></script>
@endsection