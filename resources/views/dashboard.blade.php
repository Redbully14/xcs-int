<?php $page_name = 'dashboard' ?>

@extends('master.app')

@section('customcss')
<link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">	
<link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
@endsection

@section('content')
<div class="content-wrapper">
	<div class="row">
	  <div class="col-12 grid-margin stretch-card">
	    <div class="card corona-gradient-card">
	      <div class="card-body py-0 px-0 px-sm-3">
	        <div class="row align-items-center">
	          <div class="col-4 col-sm-3 col-xl-2">
	            <img src="/assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
	          </div>
	          <div class="col-5 col-sm-7 col-xl-8 p-0">
	            <h4 class="mb-1 mb-sm-0">New refreshing & better Antelope</h4>
	            <p class="mb-0 font-weight-normal d-none d-sm-block">Antelope	 now with a new facelift for enhanced legibility and aesthetics!</p>
	          </div>
	          <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
	            <button class="btn btn-outline-light btn-rounded get-started-btn">Get Started</button>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@endsection

@section('pluginjs')
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="/assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
@endsection