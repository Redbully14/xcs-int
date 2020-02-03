<?php $page_name = 'absence_database' ?>

@extends('master.app')

@section('customcss')

@endsection

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Absence Database </h3>
  </div>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Absences Awaiting Review</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive" id="ajax_absence_database_AR-div">
            <table id="ajax_absence_database_AR-table" class="table table-bordered">
              <thead>
                <tr>
                  <th>Absence ID</th>
                  <th>Name & Unit Number</th>
                  <th>Website ID</th>
                  <th>Absence Start & End Date</th>
                  <th>Absence Link</th>
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
@endsection

@section('injectjs')
<script text="text/javascript">
  var $url = "{{ url('/absence/datatable/0') }}";
  var $absence_id = "{{ $constants['global_id']['absence'] }}";
</script>
<script src="/js/absence_database.js"></script>
@endsection

@section('modals')
@endsection