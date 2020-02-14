<?php $page_name = 'dashboard' ?>

@extends('master.app')

@section('customcss')
@endsection

@section('content')
<div class="content-wrapper">
	@if($feedback == false)
	<div id="feedback_notsubmitted_div" class="row">
	  <div class="col-12 grid-margin stretch-card">
	    <div class="card corona-gradient-card">
	      <div class="card-body py-0 px-0 px-sm-3">
	        <div class="row align-items-center">
	          <div class="col-4 col-sm-3 col-xl-2">
	            <img src="/assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
	          </div>
	          <div class="col-5 col-sm-7 col-xl-8 p-0">
	            <h4 class="mb-1 mb-sm-0">Your feedback matters!</h4>
	            <p class="mb-0 font-weight-normal d-none d-sm-block">This system was made with nothing but pure love from the AntelopePHP Development Team, <b>your feedback is important to us!</b> Please let us know, what you think about the new system.</p>
	          </div>
	          <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
	            <button class="btn btn-outline-light btn-rounded get-started-btn" id="feedback_modal-open">Submit feedback</button>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	@endif
	@if(auth()->user()->requirements_exempt == false)
	<div class="row">

	  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
	    <div class="card">
	      <div class="card-body">
	        <div class="row">
	          <div class="col-9">
	            <div class="d-flex align-items-center align-self-start">
	              <h3 class="mb-0 text-{{ $calculations['requirements']['logs_met'] ? 'success' : 'danger' }}">{{ $calculations['requirements']['logs'] }}</h3>
	              <p class="text-{{ $calculations['requirements']['logs_met'] ? 'success' : 'danger' }} ml-2 mb-0 font-weight-medium">Log(s)</p>
	            </div>
	          </div>
	          <div class="col-3">
	            <div class="icon icon-box-{{ $calculations['requirements']['logs_met'] ? 'success' : 'danger' }}">
	              <span class="mdi {{ $calculations['requirements']['logs_met'] ? 'mdi-check' : 'mdi-exclamation' }} icon-item"></span>
	            </div>
	          </div>
	        </div>
	        <h6 class="text-muted font-weight-normal">Still required this month</h6>
	      </div>
	    </div>
	  </div>

	  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
	    <div class="card">
	      <div class="card-body">
	        <div class="row">
	          <div class="col-9">
	            <div class="d-flex align-items-center align-self-start">
	              <h3 class="mb-0 text-{{ $calculations['requirements']['hours_met'] ? 'success' : 'danger' }}">{{ $calculations['requirements']['hours'] }}</h3>
	              <p class="text-{{ $calculations['requirements']['hours_met'] ? 'success' : 'danger' }} ml-2 mb-0 font-weight-medium">Hour(s)</p>
	            </div>
	          </div>
	          <div class="col-3">
	            <div class="icon icon-box-{{ $calculations['requirements']['hours_met'] ? 'success' : 'danger' }}">
	              <span class="mdi {{ $calculations['requirements']['hours_met'] ? 'mdi-check' : 'mdi-exclamation' }} icon-item"></span>
	            </div>
	          </div>
	        </div>
	        <h6 class="text-muted font-weight-normal">Still required this month</h6>
	      </div>
	    </div>
	  </div>

	  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
	    <div class="card">
	      <div class="card-body">
	        <div class="row">
	          <div class="col-9">
	            <div class="d-flex align-items-center align-self-start">
	              <h3 class="mb-0">{{ $calculations['this_month_logs'] }}</h3>
	              <p class="ml-2 mb-0 font-weight-medium">Log(s)</p>
	            </div>
	          </div>
	          <div class="col-3">
	            <div class="icon icon-box-warning">
	              <span class="mdi mdi-clock icon-item"></span>
	            </div>
	          </div>
	        </div>
	        <h6 class="text-muted font-weight-normal">Logged patrols this month</h6>
	      </div>
	    </div>
	  </div>

	  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
	    <div class="card">
	      <div class="card-body">
	        <div class="row">
	          <div class="col-9">
	            <div class="d-flex align-items-center align-self-start">
	              <h3 class="mb-0">{{ $calculations['this_month_hours'] }}</h3>
	              <p class="ml-2 mb-0 font-weight-medium">Hour(s)</p>
	            </div>
	          </div>
	          <div class="col-3">
	            <div class="icon icon-box-warning">
	              <span class="mdi mdi-book icon-item"></span>
	            </div>
	          </div>
	        </div>
	        <h6 class="text-muted font-weight-normal">Logged hours this month</h6>
	      </div>
	    </div>
	  </div>

	</div>
	@endif
	@if(Auth::user()->level() >= $constants['access_level']['staff'])
	<div class="row">
      <div class="col-sm-4 grid-margin">
        <div class="card">
          <div class="card-body">
            <h5>Absences</h5>
            <div class="row">
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                  <h2 class="mb-0">0</h2>
                </div>
                <h6 class="text-muted font-weight-normal">Awaiting approval</h6>
              </div>
              <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-clock text-primary ml-auto"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4 grid-margin">
        <div class="card">
          <div class="card-body">
            <h5>Placeholder</h5>
            <div class="row">
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                  <h2 class="mb-0">0</h2>
                </div>
                <h6 class="text-muted font-weight-normal">placeholder</h6>
              </div>
              <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4 grid-margin">
        <div class="card">
          <div class="card-body">
            <h5>Placeholder</h5>
            <div class="row">
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                  <h2 class="mb-0">0</h2>
                </div>
                <h6 class="text-muted font-weight-normal">placeholder</h6>
              </div>
              <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
</div>
@endsection

@section('modals')
@include('modals.submit_feedback_modal')
@endsection