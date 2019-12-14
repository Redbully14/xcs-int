<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $constants['application_name'] }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link href="/assets/vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/xcs-int/custom.css">
    <link rel="stylesheet" href="/assets/css/modern-vertical/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100">
          <div class="content-wrapper full-page-wrapper auth login-2 login-bg">
            <div class="card col-lg-4">
              <div class="card-body px-5 py-5">
                <h1 class="card-title text-left mb-3" id="xcs-header"><i id="xcs-header-icon" class="{{ $constants['application_icon'] }} rotate-n-15"></i> {{ $constants['application_name'] }}<sup id='xcs-header-sub'>{{ $constants['application_subname'] }}</sup></h1>
                <h3 class="card-title text-left mb-3">Login</h3>
                <form method="POST" action="{{ route('login') }}">
                  @csrf

                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control p_input" id="username" name="username" required autofocus>
                  </div>

                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control p_input" id="password" name="password" required>
                  </div>

                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label" for="remember">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember"> Remember me </label>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>