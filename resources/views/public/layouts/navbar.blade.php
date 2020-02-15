<nav class="bottom-navbar">
  <div class="container">
    <ul class="nav page-navigation">
      @if(isset(Auth::user()->name))
      <li class="nav-item menu-items">
        <a class="nav-link" href="/dashboard">
          <i class="mdi mdi-speedometer menu-icon"></i>
          <span class="menu-title">Return to Dashboard</span>
        </a>
      </li>
      @endif
      <li class="nav-item menu-items">
        <a class="nav-link" href="/public/roster">
          <i class="mdi mdi-collage menu-icon text-white"></i>
          <span class="menu-title">Public Roster</span>
        </a>
      </li>
    </ul>
  </div>
</nav>