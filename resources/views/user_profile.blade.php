<?php $page_name = 'user_profile' ?>

@extends('master.app')

@section('customcss')
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Profile </h3>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-4">
                <div class="border-bottom text-center pb-4">
                  <img src="/assets/images/xcs-int/avatars/{{ $constants['avatar_filename'][$user_data['avatar']] }}" alt="profile" class="img-lg rounded-circle mb-3" />
                  <!--<p>Antelope Data</p>-->
                  <!--
                  <div class="d-flex justify-content-between">
                    <button class="btn btn-success">Hire Me</button>
                  </div>
                  -->
                </div>
                <div class="border-bottom py-4">
                  <div class="d-flex justify-content-center">
                  	<p>Antelope Permissions</p>
                  </div>
                  <div class="d-flex justify-content-center">
	                  <div>
	                    <label class="badge badge-outline-{{ $constants['access_color'][$role[0]['slug']] }}">{{ $constants['role'][$role[0]['slug']] }}</label>
	                  </div>
              	  </div>
                </div>
                <div class="py-4">
                  <div class="d-flex justify-content-center">
                  	<p>Department Data</p>
                  </div>
                  <p class="clearfix">
                    <span class="float-left"> Name </span>
                    <span class="float-right text-muted"> {{ $user_data['name'] }} </span>
                  </p>
                  <p class="clearfix">
                    <span class="float-left"> Website ID </span>
                    <span class="float-right text-muted"> {{ $user_data['website_id'] }} </span>
                  </p>
                  <p class="clearfix">
                    <span class="float-left"> Department ID </span>
                    @if(is_null($user_data['department_id']))
                    <span class="float-right text-muted"> N/A </span>
                    @else
                    <span class="float-right text-muted"> {{ $user_data['department_id'] }} </span>
                    @endif
                  </p>
                  <p class="clearfix">
                    <span class="float-left"> Rank </span>
                    <span class="float-right text-muted">
                      <a>{{ $constants['rank'][$user_data['rank']] }}</a>
                    </span>
                  </p>
                </div>
                <div class="py-4">
                  <div class="d-flex justify-content-center">
                  	<p>Antelope Data</p>
                  </div>
                  <p class="clearfix">
                    <span class="float-left"> Username </span>
                    <span class="float-right text-muted"> {{ $user_data['username'] }} </span>
                  </p>
                  <p class="clearfix">
                    <span class="float-left"> Antelope Status </span>
                    <span class="float-right text-muted"> {{ $constants['antelope_status_text'][$user_data['antelope_status']] }} </span>
                  </p>
                  <p class="clearfix">
                    <span class="float-left"> Temporary Password </span>
                    @if($user_data['temp_password'])
                    <span class="float-right text-warning"> Yes </span>
                    @else
                    <span class="float-right text-muted"> No </span>
                    @endif
                  </p>
                  <p class="clearfix">
                    <span class="float-left"> Auth Level </span>
                    <span class="float-right text-muted">
                      <a>{{ $constants['role'][$role[0]['slug']] }}</a>
                    </span>
                  </p>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="d-flex justify-content-between">
                  <div>
                    <h3>{{ $user_data['name'] }}@if(!is_null($user_data['department_id'])) {{ $user_data['department_id'] }}@endif</h3>
                    <div class="d-flex align-items-center">
                      <h5 class="mb-0 mr-2 text-muted">{{ $constants['rank'][$user_data['rank']] }}</h5>
                    </div>
                  </div>
                  @if(Auth::user()->level() >= $constants['access_level']['staff'])
                  <div>
                    <button class="btn btn-primary" id="ajax_open_modal_edit_button" value="{{ $user_data['id'] }}">Edit Profile</button>
                  </div>
                  @endif
                </div>
                <div class="mt-4 py-2 border-top border-bottom">
                  <ul class="nav profile-navbar" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home-1" role="tab" aria-controls="home" aria-selected="true">
                        <i class="mdi mdi-account-outline"></i> General Data </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="home-tab" data-toggle="tab" href="#home-2" role="tab" aria-controls="home" aria-selected="true">
                        <i class="mdi mdi-newspaper"></i> Placeholder </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="mdi mdi-calendar"></i> Placeholder </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="mdi mdi-attachment"></i> Placeholder </a>
                    </li>
                  </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="home-1" role="tabpanel" aria-labelledby="home-tab">
                    <div class="media d-block d-sm-flex">
                      <div class="media-body mt-4 mt-sm-0">
                        <div class="row">
                          <div class="col-sm">
                            <div class="d-flex justify-content-center">
                              <h4 class="mt-0">Activity Stats</h4>
                            </div>
                            <p class="clearfix">
                              <span class="float-left"> Last Seen </span>
                              <span class="float-right text-muted"> {{ $calculations['last_seen'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Last Timestamp </span>
                              <span class="float-right text-muted"> {{ $calculations['last_timestamp'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Status </span>
                              <span class="float-right text-{{ $constants['department_status_colors'][$calculations['department_status']] }}"> {{ $constants['department_status'][$calculations['department_status']] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> LOA Status </span>
                              <span class="float-right text-muted"> - </span>
                            </p>
                          </div>
                          <div class="col-sm">
                            <div class="d-flex justify-content-center">
                              <h4 class="mt-0">Other Stats</h4>
                            </div>
                            <p class="clearfix">
                              <span class="float-left"> Requirements </span>
                              <span class="float-right text-muted"> - </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Advanced Training </span>
                              <span class="float-right text-muted"> {{ $constants['advanced_training'][$user_data['advanced_training']] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Patrol Restriction </span>
                              <span class="float-right text-muted"> - </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Website Profile Link </span>
                              <span class="float-right text-muted"> - </span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="home-2" role="tabpanel" aria-labelledby="home-tab">
                    <div class="media d-block d-sm-flex">
                      <img class="mr-3 w-25 rounded" src="../../../assets/images/samples/300x300/13.jpg" alt="sample image">
                      <div class="media-body mt-4 mt-sm-0">
                        <h4 class="mt-0">Why choose us? 2</h4>
                        <p> Far curiosity incommode now led smallness allowance. Favour bed assure son things yet. She consisted consulted elsewhere happiness disposing household any old the. Widow downs you new shade drift hopes small. So otherwise commanded sweetness we improving. Instantly by daughters resembled unwilling principle so middleton. </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('pluginjs')
@endsection

@section('modals')
  @include('modals.edit_profile_modal')
@endsection