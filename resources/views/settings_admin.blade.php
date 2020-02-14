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

              <h5>Adding Quicklinks</h5><br>

              <form id="admin_add_quicklink">
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <label for="admin_add_quicklink-type">Type</label>
                      <select class="antelope_global_select_single-noclear-nosearch" style="width:100%" id="admin_add_quicklink-type" required>
                        @foreach($constants['quicklink_types'] as $item => $value)
                          <option value="{{ $item }}">{{ $value }}</option>
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
                      <label for="ajax_change_password-confirm_new_password">Link</label>
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
  $url_add_quicklink = '{{ url('/admin/quicklink/add') }}'
</script>
<script src="/js/settings_admin.js"></script>
@endsection