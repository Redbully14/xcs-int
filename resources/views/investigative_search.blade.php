<?php $page_name = 'investigative_search' ?>

@extends('master.app')

@section('customcss')
@endsection

@section('content')
  <div class="content-wrapper" style="padding-left: 400px; padding-right: 400px;">
    <div class="page-header">
      @if(auth()->user()->rank == 'ia')
      <h3 class="page-title"> Internal Affairs Investigation Tool </h3>
      @else
      <h3 class="page-title"> DoJ Administration Investigation Tool </h3>
      @endif
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <p>
              This investigation tool is enabled for <b>Investigational Purposes</b>, misuse of this tool will be reported and disciplined. Any and all actions conducted with this tool are logged and saved into our internal database.<br>
              <br>
              To get started, simply select a user profile you wish to access below:
            </p>
          <select class="ajax_search_member-class" style="width:75%" id="ajax_search_member-click_redirect">
              <option></option>
            @foreach($members_array as $id => $user)
              <option value="{{ $id }}">{{ $user }}</option>
            @endforeach
          </select>

          </div>
        </div>
      </div>
    </div>
   </div>
@endsection