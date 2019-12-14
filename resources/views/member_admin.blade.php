@extends('master.app')

@section('content')
<div class="content-wrapper" style="padding-bottom: 650px;">
  <div class="page-header">
    <h3 class="page-title"> Data table </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Tables</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data table</li>
      </ol>
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
@endsection