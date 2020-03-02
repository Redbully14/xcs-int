@inject('notifications', 'App\Http\Controllers\AntelopeNotifications')

<li class="nav-item dropdown border-left">
  <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
    <i class="mdi mdi-bell"></i>
    @if($notifications::notificationCount())
    <span class="count bg-danger"></span>
    @endif
  </a>
  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
    <h6 class="p-3 mb-0">Notifications</h6>
    <div class="dropdown-divider"></div>
    @foreach($notifications::unreadNotifications() as $notification)
    <a class="dropdown-item preview-item">
      <div class="preview-thumbnail">
        <div class="preview-icon bg-dark rounded-circle">
          <i class="{{ $notification->data['icon'] }} text-{{ $notification->data['color'] }}"></i> 
        </div>
      </div>
      <div class="preview-item-content">
        <p class="preview-subject mb-1">{{ $notification->data['title'] }}</p>
        <p class="text-muted ellipsis mb-0"> {{ $notification->data['text'] }} </p>
      </div>
    </a>
    @endforeach
    @if(!$notifications::notificationCount())
    <p class="p-3 mb-0 text-center">Wow this place is empty!</p>
    @endif
  </div>
</li>