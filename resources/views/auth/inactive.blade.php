<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $constants['global']['application_name'] }} :: {{ $constants['department']['department_name'] }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/modern-vertical/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/xcs-info/{{ $constants['global']['application_favicon'] }}" />
  </head>
  <body style="margin-bottom: -30px">
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100" style="margin-left: 0px">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg" style="background:url('{{$constants['backgrounds']['inactive']}}'); background-size: cover;">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <div class="alert alert-danger" role="alert"><i class="mdi mdi-alert-circle"></i> Your account is currently deactivated, contact a member of your Chain of Command for more information! </div>
              </div>
              <div class="text-center">
                <button type="button" class="btn btn-primary btn-block enter-btn" onclick="window.location.href = '{{ url('login') }}';">Back to login</button>
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
