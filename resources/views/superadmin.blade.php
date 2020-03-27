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
                        @canBeImpersonated($baseXCS::getUser($id))
                          <option value="{{ $id }}">{{ $user }}</option>
                        @endCanBeImpersonated
                      @endforeach
                    </select>
                  </div>

                  <button type="submit" class="btn btn-warning mr-2">Takeover User</button>
                </form>
                <br>
                <h5>Bulk Notify</h5><br>
                <form action="/superadmin/notify" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-2">
                      <div class="form-group">
                        <label for="admin_add_quicklink-type">Title</label>
                        <input type="text" class="form-control" id="superadmin_notify-title" name="title" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-2">
                      <div class="form-group">
                        <label for="admin_add_quicklink-type">Icon (mdi / favicon)</label>
                        <input type="text" class="form-control" id="superadmin_notify-icon" name="icon" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-5">
                      <div class="form-group">
                        <label for="admin_add_quicklink-title">Text</label>
                        <input type="text" class="form-control" id="superadmin_notify-title" name="text" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="admin_add_quicklink-link">Color</label>
                          <select class="antelope_global_select_single-noclear-nosearch" name="color" style="width:100%" id="superadmin_notify-color" required>
                            @foreach($constants['font_colors'] as $item)
                              <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                          </select>                      
                      </div>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-warning mr-2">Send notification</button>
                </form>
                <hr>
                <br>
                <a href="/superadmin/icons">Material Design Icons</a><br>
                <a href="/superadmin/icons2">Font Awesome Icons</a>
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