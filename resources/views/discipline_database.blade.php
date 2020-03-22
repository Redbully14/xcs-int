<?php $page_name = 'discipline_database' ?>

@extends('master.app')

@section('customcss')

@endsection

@section('content')
<div class="content-wrapper">
<!-- <div class="alert alert-fill-warning" role="alert">
  <i class="mdi mdi-worker"></i> This module is currently disabled by the AntelopePHP Development Team.
</div> -->
  <div class="page-header">
    <h3 class="page-title"> Discipline Database </h3>
    <nav aria-label="breadcrumb">
	<button class="nav-link btn btn-danger create-new-button" href="#" id="ajax_add_disciplinary_action-button">+ Submit Disciplinary Action</button>
    </nav>
  </div>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Disciplinary Actions</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive" id="ajax_disciplinary_actions_table_div">
            <table id="ajax_disciplinary_actions_table_element" class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Issued to</th>
                  <th>Issued by</th>
                  <th>Discipline type</th>
                  <th>Discipline date</th>
                  <th>Discipline details</th>
                  <th>Disciplinary status</th>
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
<script type="text/javascript">
  var $url = '{{ url('discipline/collection') }}';
  var $discipline_id = '{{ $constants['global_id']['disciplinary_action'] }}';
  var $discipline_table = "#ajax_disciplinary_actions_table_element";
</script>
<script src="/js/discipline_database.js"></script>
@endsection

@section('modals')
@include('modals.add_disciplinary_action_modal')
@include('modals.edit_disciplinary_action_modal')
@endsection
