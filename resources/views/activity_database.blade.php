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
                  <th>Name & Unit Number</th>
                  <th>Website ID</th>
                  <th>Patrol Date</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Patrol Details</th>
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
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
@endsection

@section('ajax')
<script text="text/javascript">
  $(function() {
    $('#tableElement').DataTable({
     ordering: false,
     serverSide: true,
     searching: false,
     ajax: '{{ url('activity/collection') }}',
     columns: [
      { data: 'id', name: 'id', render: function (data, type, row) {
        return  '{{ $constants['global_id']['patrol_log'] }}' + data;
      } },
      { data: 'name_department_id', name: 'name_department_id' },
      { data: 'website_id', name: 'website_id' },
      { data: 'patrol_date', name: 'patrol_date' },
      { data: 'start_time', name: 'start_time' },
      { data: 'end_time', name: 'end_time' },
      { data: 'details', name: 'details', render: function (data, type, row) {
        var allowedLength = 35;
        if (data.length >= allowedLength) {
          return data.substr(0, allowedLength)+'...';
        } else {
          return data;
        };
      } },
      { data: 'id', searchable: false, render: function(data, type, row) { return '<button id="ajax_view_patrol_log_open" value="'+data+'">View</button>'; } }
     ]
    });
  });
</script>
@endsection

@section('modals')
@include('modals.show_patrol_log_modal')
@endsection