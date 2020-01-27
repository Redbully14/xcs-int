<?php $page_name = 'superadmin' ?>

@inject('baseXCS', 'App\Http\Controllers\BaseXCS')

@extends('master.app')

@section('customcss')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> SuperAdmin </h3>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">

              	<h5>Takeover a User</h5><br>

				        <form id="ajax_superadmin_takeover">

                  <div class="form-group">
                    <label>User</label>
                    <select class="ajax_search_member-class" style="width:100%" id="ajax_superadmin_takeover-user" required>
                        <option></option>
                      @foreach($baseXCS::getAllMembers() as $id => $user)
                        <option value="{{ $id }}">{{ $user }}</option>
                      @endforeach
                    </select>
                  </div>

                  <button type="submit" class="btn btn-warning mr-2">Takeover User</button>
                </form><hr>
          </div>
        </div>
      </div>
	</div>
</div>
@endsection

@section('injectjs')
<script type="text/javascript">
  var $url_superadmin_takeover = '{{ url('superadmin/godmode/') }}';
  var $url_superadmin_replace = '{{ url('dashboard') }}';
</script>
<script src="/js/superadmin.js"></script>
@endsection