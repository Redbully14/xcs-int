<?php $page_name = 'internal_roster' ?>

@extends('master.app')

@section('content')
<style>
table {
  table-layout: fixed !important;
  word-wrap: break-word !important;
}

.internal_roster-changed {
    border: 2px solid rgba(71, 164, 71, 1) !important;
}

</style>
<div class="content-wrapper">
	<div class="row">
		<h1>Internal Roster - {{ $constants['department']['department_name'] }}</h1>
	</div>
  <form id="internal_roster-form" onsubmit="setFormSubmitting()">
  	<button type="submit" class="btn btn-success mr-2">Save Roster Changes</button>
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
              <table id="internal_roster-admins" class="table table-bordered">
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
              <table id="internal_roster-seniorstaff" class="table table-bordered">
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
              <table id="internal_roster-staff" class="table table-bordered">
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
              <table id="internal_roster-staffintraining" class="table table-bordered">
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
              <table id="internal_roster-seniormembers" class="table table-bordered">
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
              <table id="internal_roster-members" class="table table-bordered">
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
              <table id="internal_roster-probationarymembers" class="table table-bordered">
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
              <table id="internal_roster-reserves" class="table table-bordered">
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
              <table id="internal_roster-media" class="table table-bordered">
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
  </form>
</div>
@endsection

@section('injectjs')
<script text="text/javascript">

  function internal_roster_rankFieldInput(data, id) {
    var ranks = {
      @foreach($constants['rank'] as $item => $value)
      "{{ $value }}" : "{{ $item }}",
      @endforeach
    };

    var returndata = '<select class="antelope_global_select_single-noclear internal_roster-input_rank" data-user-id="'+id+'" onchange="internalRoster_changed(this)" style="width:100%"> @foreach($constants["rank"] as $item => $value) <option value="{{ $item }}" '+checkifMatchthenSelectIt(data, "{{ $value }}")+'>{{ $value }}</option> @endforeach </select>'

    return returndata;
  }

  function checkifMatchthenSelectIt(data, value) {
    if (data == value) {
      return 'selected';
    } else return;
  }

</script>
<script src="/js/internal_roster.js"></script>
@endsection