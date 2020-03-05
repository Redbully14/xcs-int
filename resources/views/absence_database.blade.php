<?php $page_name = 'absence_database' ?>

@extends('master.app')

@section('customcss')

@endsection

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Absence Database </h3>
    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
    <nav aria-label="breadcrumb">
      <a class="nav-link btn btn-warning create-new-button" href="/absence/archive">Access Archive</a>
    </nav>
    @endif
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
      <hr>
      <h4 class="card-title">Active Absences</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive" id="ajax_absence_database_A-div">
            <table id="ajax_absence_database_A-table" class="table table-bordered">
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
  var $absence_id = "{{ $constants['global_id']['absence'] }}";
  var $url_absence_btn_approve = "{{ url('/absence/approve/') }}/";
  var $url_absence_btn_archive = "{{ url('/absence/archive/') }}/";
  var $url_absence_btn_queue = "{{ url('/absence/queue/') }}/";
</script>
<script src="/js/absence_database.js"></script>
@endsection

@section('modals')
@endsection