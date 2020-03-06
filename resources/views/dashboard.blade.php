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
                  <h2 class="mb-0">{{ $calculations['needs_approval'] }}</h2>
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
            <h5>Absences</h5>
            <div class="row">
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                  <h2 class="mb-0">{{ $calculations['overdue_absences'] }}</h2>
                </div>
                <h6 class="text-muted font-weight-normal">Currently overdue</h6>
              </div>
              <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-clock-alert text-danger ml-auto"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4 grid-margin">
        <div class="card">
          <div class="card-body">
            <h5>Activity Logs</h5>
            <div class="row">
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                  <h2 class="mb-0">{{ $calculations['invalidated_logs'] }}</h2>
                </div>
                <h6 class="text-muted font-weight-normal">Pending review</h6>
              </div>
              <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-book text-warning ml-auto"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

	<div class="row">
	  <div class="col-md-6 grid-margin stretch-card">
	    <div class="card">
	      <div class="card-body">
	        <h4 class="card-title">Departmental Announcements</h4>
	        <div class="alert alert-fill-warning" role="alert">
	          <i class="mdi mdi-worker"></i> The AntelopePHP Development Team is working hard to implement this feature, <b>if you show interest in this being implemented as soon as possible</b>, please let us know via the feedback form.
	        </div>

	        <!--
	        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
	          <div class="text-md-center text-xl-left">
	            <h6 class="mb-1">Transfer to Paypal</h6>
	            <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
	          </div>
	          <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
	            <h6 class="font-weight-bold mb-0">$236</h6>
	          </div>
	        </div>
	        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
	          <div class="text-md-center text-xl-left">
	            <h6 class="mb-1">Tranfer to Stripe</h6>
	            <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
	          </div>
	          <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
	            <h6 class="font-weight-bold mb-0">$593</h6>
	          </div>
	        </div>
	        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
	          <div class="text-md-center text-xl-left">
	            <h6 class="mb-1">Tranfer to Stripe</h6>
	            <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
	          </div>
	          <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
	            <h6 class="font-weight-bold mb-0">$593</h6>
	          </div>
	        </div>
	        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
	          <div class="text-md-center text-xl-left">
	            <h6 class="mb-1">Tranfer to Stripe</h6>
	            <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
	          </div>
	          <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
	            <h6 class="font-weight-bold mb-0">$593</h6>
	          </div>
	        </div>
	    	-->
	      </div>
	    </div>
	  </div>
	  <div class="col-md-6 grid-margin stretch-card">
	    <div class="card">
	      <div class="card-body">
	        <div class="d-flex flex-row justify-content-between">
	          <h4 class="card-title mb-1">Quick Links</h4>
	        </div>
	        <div class="row">
	          <div class="col-12">
	            <div class="preview-list">

	              @foreach($quicklinks as $quicklink)
	              <div class="preview-item border-bottom">
	                <div class="preview-thumbnail">
	                  <div class="preview-icon bg-{{ $constants['quicklink_types'][$quicklink[0]]['color'] }}">
	                    <i class="{{ $constants['quicklink_types'][$quicklink[0]]['icon'] }}"></i>
	                  </div>
	                </div>
	                <div class="preview-item-content d-sm-flex flex-grow">
	                  <div class="flex-grow">
	                    <h6 class="preview-subject">{{ $quicklink[1] }}</h6>
	                    <a class="mb-0" href="{{ $quicklink[2] }}" target="_blank">Click here to view</a>
	                  </div>
	                </div>
	              </div>
	              @endforeach

	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@endsection

@section('modals')
@include('modals.submit_feedback_modal')
@endsection
