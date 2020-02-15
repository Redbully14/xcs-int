<?php $page_name = 'public_roster' ?>

@extends('public.layouts.app')

@section('content')
<div class="content-wrapper">
	<div class="row">
		<h1>Public Roster - {{ $constants['department']['department_name'] }}</h1>
	</div>
	<br>
	<br>
	<div class="row">
		<h3>Department Administration</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-admins" class="table table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Unit Number</th>
                  <th>Website ID</th>
                  <th>Rank</th>
                  <th>Status</th>
                  <th>Monthly Hours</th>
                  <th>Monthly Logs</th>
                  <th>Advanced Training</th>
                  <th>Requirements</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
	</div>
</div>
@endsection

@section('injectjs')
<script text="text/javascript">
  var $url_admins = '{{ url('public/roster/admins') }}';
  var $activity_table = "#public_roster-admins";
</script>
<script src="/js/public/public_roster.js"></script>
@endsection