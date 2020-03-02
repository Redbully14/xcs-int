@inject('notifications', 'App\Http\Controllers\AntelopeNotifications')

<?php
 
  $notification_count = $notifications::notificationCount();

?>

<li class="nav-item dropdown border-left">
  <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
    @if($notification_count)
    <i class="mdi mdi-bell-ring"></i>
    <span class="count bg-danger" id="notificationAlert"></span>
    @else
    <i class="mdi mdi-bell"></i>
    @endif
  </a>
  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
    <h6 class="p-3 mb-0">Notifications</h6>
    <div class="dropdown-divider"></div>
    @foreach($notifications::unreadNotifications() as $notification)
    <a class="dropdown-item preview-item antelope-notification" data-notification-id="{{ $notification->notifiable_id }}" href="/notifications">
      <div class="preview-thumbnail">
        <div class="preview-icon bg-dark rounded-circle">
          <i class="{{ $notification->data['icon'] }} text-{{ $notification->data['color'] }}"></i> 
        </div>
      </div>
      <div class="preview-item-content">
        <p class="preview-subject mb-1">{{ $notification->data['title'] }}</p>
        <p class="ellipsis mb-0"> {{ $notification->data['text'] }} </p>
      </div>
    </a>
    @endforeach
    @if(!$notification_count)
    <a class="dropdown-item preview-item antelope-notification" href="/notifications">
      <p class="p-3 mb-0 text-center antelope-notifications-none"> {{ $notifications::notificationQuirk() }} </p>
    </a>
    @endif
    <div class="dropdown-divider"></div>
    <a class="p-2 mb-0 text-small text-danger" href="#" onclick="clearAllNotifications()">Mark all as read</a>
  </div>
</li>