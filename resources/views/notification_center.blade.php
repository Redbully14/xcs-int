<?php $page_name = 'notification_center' ?>

@extends('master.app')

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Notification Center </h3>
    <nav aria-label="breadcrumb">
      <a class="nav-link btn btn-primary" href="/notifications/clearall_center">Mark all as read</a>
    </nav>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="preview-list">

            @foreach($notifications as $notification)
            <div class="preview-item border-bottom">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-{{ $notification->data['color'] }}">
                  <i class="{{ $notification->data['icon'] }}"></i>
                </div>
              </div>
              <div class="preview-item-content d-sm-flex flex-grow">
                <div class="flex-grow @if($notification->read_at) text-muted @endif">
                  <h6 class="preview-subject">{{ $notification->data['title'] }}</h6>
                  <p class="mb-0">{{ $notification->data['text'] }}</p>
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
@endsection

@section('injectjs')
@endsection