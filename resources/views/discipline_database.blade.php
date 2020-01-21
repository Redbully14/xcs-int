<?php $page_name = 'discipline_database' ?>

@extends('master.app')

@section('customcss')

@endsection

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Discipline Database </h3>
    <nav aria-label="breadcrumb">
      <a class="nav-link btn btn-danger create-new-button" href="#" id="ajax_add_disciplinary_action-button">+ Submit Disciplinary Action</a>
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

@section('ajax')
<script text="text/javascript">
  $(function() {
    $('#ajax_disciplinary_actions_table_element').DataTable({
     ordering: true,
     serverSide: true,
     searching: true,
     ajax: '{{ url('discipline/collection') }}',
     columns: [
      { data: 'discipline_id', name: 'discipline_id', render: function (data, type, row) {
        return  '{{ $constants['global_id']['disciplinary_action'] }}' + data;
      } },
      { data: 'issued_to', name: 'issued_to' },
      { data: 'issued_by', name: 'issued_by' },
      { data: 'discipline_type', name: 'discipline_type', searchable: false },
      { data: 'discipline_date', name: 'discipline_date' },
      { data: 'discipline_details', name: 'discipline_details', searchable: false, render: function (data, type, row) {
        var allowedLength = 35;
        if (data.length >= allowedLength) {
          return data.substr(0, allowedLength)+'...';
        } else {
          return data;
        };
      } },
      { data: 'discipline_status', name: 'discipline_status', searchable: false },
      { data: 'discipline_id', searchable: false, render: function(data, type, row) { return '<button class="btn btn-outline-primary" id="ajax_edit_disciplinary_action-table" value="'+data+'"><i class="mdi mdi-lead-pencil"></i> Edit</button>'; } },
     ],
    });
  });
</script>
@endsection

@section('modals')
@include('modals.show_patrol_log_modal')
@include('modals.add_disciplinary_action_modal')
@include('modals.edit_disciplinary_action_modal')
@endsection