<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $constants['global']['application_name'] }} :: Registration</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/xcs-int/custom.css">
    <link rel="stylesheet" href="/assets/css/modern-vertical/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/xcs-info/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg" style="background:url('{{$constants['backgrounds']['inactive']}}'); background-size: cover;">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">{{ $constants['global']['application_name'] }} First Login</h3>
                <form>

                  <div class="form-group">
                    <label>Select your timezone</label>
                    <select class="antelope_global_select_single-noclear" style="width:100%" id="ajax_change_timezone-input">
                      @foreach (timezone_identifiers_list() as $timezone)
                      <option value="{{ $timezone }}"{{ $timezone == old('timezone', request()->user()->timezone) ? ' selected' : '' }}>{{ $timezone }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="ajax_change_password-new_password">New Password</label>
                    <input type="password" class="form-control" id="ajax_change_password-new_password" placeholder="Password">
                    <label id="ajax_change_password-new_password-error" class="error mt-2 text-danger" for="ajax_change_password-new_password" hidden></label>
                  </div>

                  <div class="form-group">
                    <label for="ajax_change_password-confirm_new_password">Confirm New Password</label>
                    <input type="password" class="form-control" id="ajax_change_password-confirm_new_password" placeholder="Password">
                    <label id="ajax_change_password-confirm_new_password-error" class="error mt-2 text-danger" for="ajax_change_password-confirm_new_password" hidden></label>
                  </div>
                  <hr>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Continue</button>
                  </div>

                  <div class="d-flex">
                    <button class="btn btn-warning col mr-2">
                      <i class="mdi mdi-account-arrow-right-outline"></i> Exit Godmode </button>
                    <button class="btn btn-google col mr-2">
                      <i class="mdi mdi-logout"></i> Logout </button>
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
    <script src="/assets/vendors/select2/select2.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/js/app.js"></script>
    <!-- endinject -->
  </body>
</html>
