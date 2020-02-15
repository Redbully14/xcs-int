<?php $page_name = 'public_roster' ?>

@extends('public.layouts.app')

@section('content')
<style>
table {
  table-layout: fixed !important;
  word-wrap: break-word !important;
}
</style>
<div class="content-wrapper">
	<div class="row">
		<h1>Public Roster - {{ $constants['department']['department_name'] }}</h1>
	</div>
	<br>
	<br>

	<div class="row">
		<h2>Department Chain of Command</h2>
	</div>
	<div class="row">
		<h3>Department Administration</h3>
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
	</div><hr>

	<div class="row">
		<h3>Department Senior Staff</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-seniorstaff" class="table table-bordered">
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
	</div><hr>

	<div class="row">
		<h3>Department Staff</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-staff" class="table table-bordered">
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
	</div><hr>

	<div class="row">
		<h3>Department Staff in Training</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-staffintraining" class="table table-bordered">
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
	</div><hr>

	<br>
	<div class="row">
		<h2>Department Members</h2>
	</div>
	<div class="row">
		<h3>Senior Members</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-seniormembers" class="table table-bordered">
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
	</div><hr>

	<div class="row">
		<h3>Members</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-members" class="table table-bordered">
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
	</div><hr>

	<div class="row">
		<h3>Probationary Members</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-probationarymembers" class="table table-bordered">
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
	</div><hr>

	<br>
	<div class="row">
		<h2>Department Reserves</h2>
	</div>
	<div class="row">
		<h3>Reserves</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-reserves" class="table table-bordered">
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
	</div><hr>

	<div class="row">
		<h3>Media</h1>
	</div>
	<div class="row">
		<div class="col-12">
          <div class="table-responsive">
            <table id="public_roster-media" class="table table-bordered">
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
  var $url_senior_staff = '{{ url('public/roster/seniorstaff') }}';
  var $url_staff = '{{ url('public/roster/staff') }}';
  var $url_staff_in_training = '{{ url('public/roster/staffintraining') }}';
  var $url_senior_member = '{{ url('public/roster/seniormember') }}';
  var $url_member = '{{ url('public/roster/member') }}';
  var $url_probationary_member = '{{ url('public/roster/probationarymember') }}';
  var $url_reserve = '{{ url('public/roster/reserve') }}';
  var $url_media = '{{ url('public/roster/media') }}';
</script>
<script src="/js/public/public_roster.js"></script>
@endsection