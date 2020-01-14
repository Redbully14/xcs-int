<?php $page_name = 'discipline_database' ?>

@extends('master.app')

@section('customcss')

@endsection

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Discipline Database </h3>
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
                  <th>Disciplinary ID</th>
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
     searching: true,
     ajax: '{{ url('discipline/collection') }}',
     columns: [
      { data: 'discipline_id', name: 'discipline_id', render: function (data, type, row) {
        return  '{{ $constants['global_id']['disciplinary_action'] }}' + data;
      } },
     ],
    });
  });
</script>
@endsection

@section('modals')
@include('modals.show_patrol_log_modal')
@endsection