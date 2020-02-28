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
                  <p class="clearfix">
                    <span class="float-left"> Exempt from Requirements </span>
                    <span class="float-right text-muted">
                      <a>{{ $user_data['requirements_exempt'] ? 'Yes' : 'No' }}</a>
                    </span>
                  </p>
                </div>
                <div class="py-4">
                  <div class="d-flex justify-content-center">
                  	<p>Antelope Data</p>
                  </div>
                  @if(Auth::user()->level() >= $constants['access_level']['admin'])
                  <p class="clearfix">
                    <span class="float-left"> Username </span>
                    <span class="float-right text-muted"> {{ $user_data['username'] }} </span>
                  </p>
                  <p class="clearfix">
                    <span class="float-left"> Antelope Status </span>
                    <span class="float-right text-{{ $constants['antelope_status_color'][$user_data['antelope_status']] }}"> {{ $constants['antelope_status_text'][$user_data['antelope_status']] }} </span>
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
                  @endif
                  <p class="clearfix">
                    <span class="float-left"> Antelope ID </span>
                    <span class="float-right text-muted"> {{ $user_data['id'] }} </span>
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
                  @if(Auth::user()->level() >= $constants['access_level']['staff'] && (Auth::user()->level() > $role[0]['level'] or Auth::user()->level() >= $constants['access_level']['admin']) && $user_data['id'] != Auth::user()->id)
                  <div>
                    <button class="btn btn-primary" id="ajax_open_modal_edit_button" value="{{ $user_data['id'] }}">Edit Profile</button>
                  </div>
                  @endif
                </div>
                <div class="mt-4 py-2 border-top border-bottom">
                  <ul class="nav profile-navbar" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="home" aria-selected="true">
                        <i class="mdi mdi-account-outline"></i> General Data </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="home-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="home" aria-selected="true">
                        <i class="mdi mdi-clock"></i> Activity Information </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="home-tab" data-toggle="tab" href="#tab-3" role="tab" aria-controls="home" aria-selected="true">
                        <i class="mdi mdi-alert-outline"></i> Disciplinary Information </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="home-tab" data-toggle="tab" href="#tab-4" role="tab" aria-controls="home" aria-selected="true">
                        <i class="mdi mdi-account-edit"></i> Profile Actions </a>
                    </li>
                  </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="info-tab">
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
                              <span class="float-right text-muted">{{ $calculations['absence_status'] }}</span>
                            </p>
                          </div>
                          <div class="col-sm">
                            <div class="d-flex justify-content-center">
                              <h4 class="mt-0">Other Stats</h4>
                            </div>
                            <p class="clearfix">
                              <span class="float-left"> Requirements </span>
                              <span class="float-right text-{{ $constants['requirements_colors'][$calculations['requirements']] }}"> {{ $constants['requirements'][$calculations['requirements']] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Advanced Training </span>
                              <span class="float-right text-muted"> {{ $user_data['advanced_training'] ? 'Yes' : 'No' }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Patrol Restriction </span>
                              <span class="float-right text-muted"> {{ $calculations['patrol_restriction'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Website Profile Link </span>
                              <span class="float-right text-muted"> <a href="https://www.dojrp.com/profile/{{ $user_data['website_id'] }}-antelope/" target="_blank">LINK</a> </span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="activity-tab">
                    <div class="media d-block d-sm-flex">
                      <div class="media-body mt-4 mt-sm-0">
                        <div class="row">
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> Monthly Hours </span>
                              <span class="float-right text-muted"> {{ $calculations['this_month_hours'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Monthly Patrols </span>
                              <span class="float-right text-muted"> {{ $calculations['this_month_logs'] }} </span>
                            </p>
                          </div>
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> 1 Week Hours </span>
                              <span class="float-right text-muted"> {{ $calculations['one_week_hours'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> 1 Week Patrols </span>
                              <span class="float-right text-muted"> {{ $calculations['one_week_logs'] }} </span>
                            </p>
                          </div>
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> 1 Month Hours </span>
                              <span class="float-right text-muted"> {{ $calculations['one_month_hours'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> 1 Month Patrols </span>
                              <span class="float-right text-muted"> {{ $calculations['one_month_logs'] }} </span>
                            </p>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> Total Hours </span>
                              <span class="float-right text-muted"> {{ $calculations['total_patrol_hours'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Total Patrols </span>
                              <span class="float-right text-muted"> {{ $calculations['total_patrol_logs'] }} </span>
                            </p>
                          </div>
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> 2 Month Hours </span>
                              <span class="float-right text-muted"> {{ $calculations['two_month_hours'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> 2 Month Patrols </span>
                              <span class="float-right text-muted"> {{ $calculations['two_month_logs'] }} </span>
                            </p>
                          </div>
                          <div class="col-sm">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="activity-tab">
                    <div class="media d-block d-sm-flex">
                      <div class="media-body mt-4 mt-sm-0">
                        <div class="row">
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> Active DA </span>
                              <span class="float-right text-muted"> {{ $calculations['total_active_discipline'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Total DA </span>
                              <span class="float-right text-muted"> {{ $calculations['total_discipline'] }} </span>
                            </p>
                          </div>
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> Active Warnings </span>
                              <span class="float-right text-muted"> {{ $calculations['warnings_active_discipline'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Total Warnings </span>
                              <span class="float-right text-muted"> {{ $calculations['warnings_total_discipline'] }} </span>
                            </p>
                          </div>
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> Active 90s </span>
                              <span class="float-right text-muted"> {{ $calculations['90s_active_discipline'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Total 90s </span>
                              <span class="float-right text-muted"> {{ $calculations['90s_total_discipline'] }} </span>
                            </p>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-sm">
                            <p class="clearfix">
                              <span class="float-left"> Active 93s </span>
                              <span class="float-right text-muted"> {{ $calculations['93s_active_discipline'] }} </span>
                            </p>
                            <p class="clearfix">
                              <span class="float-left"> Total 93s </span>
                              <span class="float-right text-muted"> {{ $calculations['93s_total_discipline'] }} </span>
                            </p>
                          </div>
                          <div class="col-sm">
                          </div>
                          <div class="col-sm">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-4" role="tabpanel" aria-labelledby="activity-tab">
                    <div class="media d-block d-sm-flex">
                      <div class="media-body mt-4 mt-sm-0">
                        <div class="row text-center">
                          <div class="col-sm">
                              <span>
							    <div>
							      @if(Auth::user()->level() >= $constants['access_level']['sit'] && (Auth::user()->level() > $role[0]['level'] or Auth::user()->level() >= $constants['access_level']['sit']) && $user_data['id'] != Auth::user()->id)
								    <button class="btn btn-danger" id="ajax_add_disciplinary_action-button" value="{{ $user_data['id'] }}" disabled><i class="mdi mdi-gavel"></i> Discipline member </button>
							      @else
								    <button class="btn btn-secondary" id="ajax_add_disciplinary_action-button" disabled><i class="mdi mdi-gavel"></i> Discipline member </button>
								  @endif
								</div>
							  </span>
                          </div>
                          <div class="col-sm">
                          </div>
                          <div class="col-sm">
                          </div>
                        </div>
                        <br>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Patrol Logs</h4>
                    <div class="row">
                      <div class="table-responsive" id="ajax_profile_activity-div">
                        <table id="ajax_profile_activity-table" class="table table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th>Patrol Log ID</th>
                              <th>Patrol Date</th>
                              <th>Start Time</th>
                              <th>End Time</th>
                              <th>Patrol Duration</th>
                              <th>Patrol Details</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if(!url('investigative_search/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET').'/profile/'.substr(url()->current(), strrpos(url()->current(), '/' )+1) == url()->current()))
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Disciplinary Actions</h4>
                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive" id="ajax_profile_discipline-div">
                          <table id="ajax_profile_discipline-table" class="table table-bordered">
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
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('injectjs')
<script type="text/javascript">
  @if(url('myprofile/') == url()->current())
  var $url_user_profile = '{{ url('activity/get_profile_logs/') }}/{{ Auth::user()->id }}';
  var $url_user_profile_discipline = '{{ url('discipline/get_profile_discipline/') }}/{{ Auth::user()->id }}';
  @elseif(url('investigative_search/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET').'/profile/'.substr(url()->current(), strrpos(url()->current(), '/' )+1) == url()->current()))
  var $url_user_profile = '{{ url('investigative_search/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET').'/profile/activity/') }}/{{ substr(url()->current(), strrpos(url()->current(), '/' )+1) }}';
  var $url_user_profile_discipline = '{{ url('investigative_search/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET').'/profile/discipline/') }}/{{ substr(url()->current(), strrpos(url()->current(), '/' )+1) }}';
  @else
  var $url_user_profile = '{{ url('activity/get_profile_logs/') }}/{{ substr(url()->current(), strrpos(url()->current(), '/' )+1) }}';
  var $url_user_profile_discipline = '{{ url('discipline/get_profile_discipline/') }}/{{ substr(url()->current(), strrpos(url()->current(), '/' )+1) }}';
  @endif
  var $user_profile_constant = '{{ $constants['global_id']['patrol_log'] }}';
  var $user_profile_constant_discipline = '{{ $constants['global_id']['disciplinary_action'] }}';
  var $activity_table = "#ajax_profile_activity-table";
  var $discipline_table = "#ajax_profile_discipline-table";
</script>
<script src="/js/user_profile.js"></script>
@endsection

@section('modals')
  @include('modals.edit_profile_modal')
  @include('modals.show_patrol_log_modal')
  @include('modals.edit_disciplinary_action_modal')
  @include('modals.add_disciplinary_action_modal')
@endsection