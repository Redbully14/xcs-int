<?php $page_name = 'activity_database' ?>

@extends('master.app')

@section('customcss')
<link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Activity Database </h3>
  </div>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Patrol Logs</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive" id="activityTable">
            <table id="tableElement" class="table table-bordered">
              <thead>
                <tr>
                  <th>Patrol Log ID</th>
                  <th>Name</th>
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
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
@endsection

@section('ajax')
<script text="text/javascript">
  $(function() {
    $('#tableElement').DataTable({
     ordering: false,
     serverSide: true,
     ajax: '{{ url('activity/collection') }}',
     columns: [
      { data: 'id', name: 'id', searchable: true },
      { data: 'name', name: 'name', searchable: true },
     ]
    });
  });
</script>
@endsection