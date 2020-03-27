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
                  <th>Total Time</th>
                  <th>Patrol Details</th>
                  <th>Flagged</th>
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
<script text="text/javascript">
  var $patrol_id = '{{ $constants['global_id']['patrol_log'] }}';
  var $activity_table = "#tableElement";
</script>
<script src="/js/activity_database.js"></script>
@endsection

@section('modals')
@include('modals.show_patrol_log_modal')
@include('modals.edit_flags_modal')
@endsection
