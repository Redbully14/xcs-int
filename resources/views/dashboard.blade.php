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
</div>
@endsection

@section('modals')
@include('modals.submit_feedback_modal')
@endsection