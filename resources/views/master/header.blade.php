<nav class="navbar p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
    <a class="navbar-brand brand-logo-mini text-{{ $constants['global']['application_color'] }}" href="/" id='xcs-header'><i id="xcs-header-icon" class="{{ $constants['global']['application_icon'] }} rotate-n-15"></i></a>
  </div>
  <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    @if(Auth::user()->level() >= $constants['access_level']['sit'])
    <ul class="navbar-nav w-100">
      <li class="nav-item w-100">
        <select class="ajax_search_member-class" style="width:75%" id="ajax_search_member-click_redirect">
            <option></option>
          @foreach($baseXCS::getAllMembersSearchable() as $id => $user)
            <option value="{{ $id }}">{{ $user }}</option>
          @endforeach
        </select>
      </li>
    </ul>
    @endif
    <ul class="navbar-nav navbar-nav-right">
      @if(Auth::user()->level() >= $constants['access_level']['member'])
      <li class="nav-item dropdown d-none d-lg-block">
        <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-toggle="dropdown" aria-expanded="false" href="#">+ Submit</a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
          <h6 class="p-3 mb-0">Submission Type</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item" data-toggle="modal" data-target="#ajax_new_patrol_log">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-book-plus text-warning"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1">Patrol Log</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item" data-toggle="modal" data-target="#absence_modal">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-clock-alert text-primary"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1">Leave of <br>Absence</p>
            </div>
          </a>
        </div>
      </li>
      @endif
      @include('master.notifications')
      <li class="nav-item dropdown">
        <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
          <div class="navbar-profile">
            <img class="img-xs rounded-circle" src="/assets/images/xcs-int/avatars/{{ $baseXCS::convertAvatar(Auth::user()->avatar, 2) }}" alt="">
            <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::user()->name }}@if(!is_null(Auth::user()->department_id)) {{ Auth::user()->department_id }}@endif</p>
            <i class="mdi mdi-menu-down d-none d-sm-block"></i>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
          <h6 class="p-3 mb-0">Profile</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item" href="/settings">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-settings text-success"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Settings</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          @impersonating
          <a class="dropdown-item preview-item" href="/superadmin/normalmode">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-account-arrow-right-outline text-warning"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Exit Godmode</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          @endImpersonating
          <a class="dropdown-item preview-item" href="/logout">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-logout text-danger"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Log out</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <p class="p-3 mb-0 text-center">AntelopePHP</p>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-format-line-spacing"></span>
    </button>
  </div>
</nav>