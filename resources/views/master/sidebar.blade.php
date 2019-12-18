<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
    <a class="sidebar-brand brand-logo" href="/" id="xcs-header"><i id="xcs-header-icon" class="{{ $constants['global']['application_icon'] }} rotate-n-15"></i> {{ $constants['global']['application_name'] }}<sup id='xcs-header-sub'>{{ $constants['global']['application_subname'] }}</sup></a>
    <a class="sidebar-brand brand-logo-mini" href="/" id="xcs-header"><i id="xcs-header-icon" class="{{ $constants['global']['application_icon'] }} rotate-n-15"></i></a>
  </div>
  <ul class="nav">
    <li class="nav-item profile">
      <div class="profile-desc">
        <div class="profile-pic">
          <div class="count-indicator">
            <img class="img-xs rounded-circle " src="/assets/images/faces/face15.jpg" alt="">
            <span class="count bg-success"></span>
          </div>
          <div class="profile-name">
            <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}@if(!is_null(Auth::user()->department_id)) {{ Auth::user()->department_id }}@endif</h5>
            <span>{{ $constants['rank'][Auth::user()->rank] }}</span>
          </div>
        </div>
        <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
          <a href="#" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-settings text-primary"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1 text-small">Account settings (not implemented yet)</p>
            </div>
          </a>
        </div>
      </div>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Navigation</span>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="/dashboard">
        <span class="menu-icon">
          <i class="mdi mdi-speedometer"></i>
        </span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    @if(Auth::user()->level() >= $constants['access_level']['admin'])
    <li class="nav-item menu-items">
      <a class="nav-link" href="/member_admin">
        <span class="menu-icon">
          <i class="mdi mdi-security"></i>
        </span>
        <span class="menu-title">Member Settings</span>
      </a>
    </li>
    @endif
  </ul>
</nav>