<?php $page_name = 'activity_database' ?>

@extends('master.app')

@section('customcss')

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
@endsection

@section('ajax')
<script text="text/javascript">
  $(function() {
    $('#tableElement').DataTable({
     ordering: true,
     serverSide: true,
     searching: false,
     order: [[ 0  , "desc" ]],
     ajax: '{{ url('activity/collection') }}',
     columns: [
      { data: 'id', name: 'id', render: function (data, type, row) {
        return  '{{ $constants['global_id']['patrol_log'] }}' + data;
      } },
      { data: 'name_department_id', name: 'name_department_id' },
      { data: 'website_id', name: 'website_id' },
      { data: 'patrol_start_end_date', name: 'patrol_start_end_date' },
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
      { data: 'id', render: function(data, type, row) { return '<button class="btn btn-outline-primary" id="ajax_view_patrol_log_open" value="'+data+'"><i class="mdi mdi-eye"></i> View</button>'; } }
     ],
    });
  });
</script>
@endsection

@section('modals')
@include('modals.show_patrol_log_modal')
@endsection