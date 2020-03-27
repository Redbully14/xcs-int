<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top fixpaddingright">
    <a class="sidebar-brand brand-logo text-{{ $constants['global']['application_color'] }}" href="/" id="xcs-header"><i id="xcs-header-icon" class="{{ $constants['global']['application_icon'] }} rotate-n-15"></i> {{ $constants['global']['application_name'] }}<sup id='xcs-header-sub'>{{ $constants['global']['application_subname'] }}</sup></a>
    <a class="sidebar-brand brand-logo-mini text-{{ $constants['global']['application_color'] }}" href="/" id="xcs-header"><i id="xcs-header-icon" class="{{ $constants['global']['application_icon'] }} rotate-n-15"></i></a>
  </div>
  <ul class="nav">
    <li class="nav-item profile">
      <div class="profile-desc">
        <div class="profile-pic">
          <div class="count-indicator">
            <img class="img-xs rounded-circle " src="/assets/images/xcs-int/avatars/{{ $baseXCS::convertAvatar(Auth::user()->avatar, 2) }}" alt="">
            <span class="count bg-success"></span>
          </div>
          <div class="profile-name">
            <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }} @if(!is_null(Auth::user()->department_id)) {{ Auth::user()->department_id }} @endif</h5>
            <span style="max-width:134px; display: block; white-space: normal;">{{ $constants['rank'][Auth::user()->rank] }}</span>
            @impersonating
            <span style="max-width:134px; display: block; white-space: normal;" class="text-warning">Godmode</span>
            @endImpersonating
          </div>
        </div>
        <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
          @if(Auth::user()->level() >= $constants['access_level']['member'])
          <a href="/myprofile" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-account-card-details text-primary"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1 text-small">My Profile</p>
            </div>
          </a>
          @endif
          <a href="/settings" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-settings text-primary"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1 text-small">Account Settings</p>
            </div>
          </a>
        </div>
      </div>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Public Access</span>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="/public/roster">
        <span class="menu-icon">
          <i class="mdi mdi-collage text-white"></i>
        </span>
        <span class="menu-title">Public Roster</span>
      </a>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Private Access</span>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="/dashboard">
        <span class="menu-icon">
          <i class="mdi mdi-speedometer text-primary"></i>
        </span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    @if(Auth::user()->level() >= $constants['access_level']['seniorstaff'])
    <li class="nav-item menu-items">
      <a class="nav-link" href="/internal_roster">
        <span class="menu-icon">
          <i class="mdi mdi-account-key text-white"></i>
        </span>
        <span class="menu-title">Internal Roster</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->rank == 'ia')
    <li class="nav-item menu-items">
      <a class="nav-link" href="/investigative_search/{{ env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET') }}">
        <span class="menu-icon">
          <i class="mdi mdi-account-search text-danger"></i>
        </span>
        <span class="menu-title">Internal Affairs</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->rank == 'other_admin')
    <li class="nav-item menu-items">
      <a class="nav-link" href="/investigative_search/{{ env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET') }}">
        <span class="menu-icon">
          <i class="mdi mdi-account-search text-danger"></i>
        </span>
        <span class="menu-title">DoJ Admin</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->level() == $constants['access_level']['member'] or Auth::user()->level() == $constants['access_level']['intern'])
    <li class="nav-item menu-items">
      <a class="nav-link" href="/myprofile">
        <span class="menu-icon">
          <i class="mdi mdi-account-card-details text-success"></i>
        </span>
        <span class="menu-title">Personal Profile</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->level() >= $constants['access_level']['staff'])
    <li class="nav-item menu-items">
      <a class="nav-link" href="/activity">
        <span class="menu-icon">
          <i class="mdi mdi-database text-warning"></i>
        </span>
        <span class="menu-title">Activity Database</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->level() >= $constants['access_level']['sit'])
    <li class="nav-item menu-items">
      <a class="nav-link" href="/discipline">
        <span class="menu-icon">
          <i class="mdi mdi-security text-danger"></i>
        </span>
        <span class="menu-title">Discipline Database</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->level() >= $constants['access_level']['staff'])
    <li class="nav-item menu-items">
      <a class="nav-link" href="/absence">
        <span class="menu-icon">
          <i class="mdi mdi-clock text-primary"></i>
        </span>
        <span class="menu-title">Absence Database</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->level() >= $constants['access_level']['admin'])
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#sidebar-administration" aria-expanded="false" aria-controls="sidebar-administration">
        <span class="menu-icon">
          <i class="mdi mdi-tie text-success"></i>
        </span>
        <span class="menu-title">Administration</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="sidebar-administration">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="/admin/settings">Admin Settings</a></li>
          <li class="nav-item"> <a class="nav-link" href="/member_admin">Member Settings</a></li>
        </ul>
      </div>
    </li>
    @endif
    @if(Auth::user()->level() >= $constants['access_level']['superadmin'])
    <li class="nav-item menu-items">
      <a class="nav-link" href="/superadmin">
        <span class="menu-icon">
          <i class="mdi mdi-ghost text-info"></i>
        </span>
        <span class="menu-title">SuperAdmin</span>
      </a>
    </li>
    @endif
  </ul>
</nav>