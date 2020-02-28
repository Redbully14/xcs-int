<?php $page_name = 'settings_admin' ?>

@extends('master.app')

@section('customcss')
@endsection

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Administrator Settings </h3>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

              <h5>Manage Quicklinks</h5><br>

              <form id="admin_manage_quicklink">
                @foreach($quicklinks as $quicklink)
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <label for="admin_manage_quicklink-type-{{ $quicklink['id'] }}">Type</label>
                      <select class="antelope_global_select_single-noclear-nosearch" style="width:100%" id="admin_manage_quicklink-type-{{ $quicklink['id'] }}" required>
                        @foreach($constants['quicklink_types'] as $item => $value)
                          <option value="{{ $item }}" {{ $item == $quicklink[0] ? ' selected' : '' }}>{{ $value['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="admin_manage_quicklink-title-{{ $quicklink['id'] }}">Quicklink Title</label>
                      <input type="text" class="form-control" id="admin_manage_quicklink-title-{{ $quicklink['id'] }}" autocomplete="off" required value="{{ $quicklink[1] }}">
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label for="admin_manage_quicklink-link-{{ $quicklink['id'] }}">Link</label>
                      <input type="url" class="form-control" id="admin_manage_quicklink-link-{{ $quicklink['id'] }}" autocomplete="off" value="{{ $quicklink[2] }}" required>
                    </div>
                  </div>
                </div>
                @endforeach
                @if (count($quicklinks))
                  <button type="submit" class="btn btn-primary mr-2">Save Quicklinks</button>
                @else
                  <p>Add some Quicklinks below!</p>
                @endif
              </form>

        </div>
      </div>
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

              <h5 class="text-success">Adding Quicklinks</h5><br>

              <form id="admin_add_quicklink">
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <label for="admin_add_quicklink-type">Type</label>
                      <select class="antelope_global_select_single-noclear-nosearch" style="width:100%" id="admin_add_quicklink-type" required>
                        @foreach($constants['quicklink_types'] as $item => $value)
                          <option value="{{ $item }}">{{ $value['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="admin_add_quicklink-title">Quicklink Title</label>
                      <input type="text" class="form-control" id="admin_add_quicklink-title" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label for="admin_add_quicklink-link">Link</label>
                      <input type="url" class="form-control" id="admin_add_quicklink-link" autocomplete="off" required>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-success mr-2">+ New Quicklink</button>
              </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('injectjs')
<script type="text/javascript">
  var $url_add_quicklink = '{{ url('/admin/quicklink/add') }}';
  var $url_manage_quicklink = '{{ url('/admin/quicklink/manage') }}';
  var $admin_manage_quicklink_count = '{{ count($quicklinks) }}';
</script>
<script src="/js/settings_admin.js"></script>
@endsection
