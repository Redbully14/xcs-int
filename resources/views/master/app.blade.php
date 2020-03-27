@inject('baseXCS', 'App\Http\Controllers\BaseXCS')

<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $constants['global']['application_name'] }} :: {{ $constants['pages'][$page_name] }}</title>

    <!-- Global Plugin CSS -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendors/jquery-toast-plugin/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/assets/vendors/jquery-bar-rating/bars-square.css">

    <!-- Plugin css for this page -->
    @yield('customcss')
    <!-- inject:css -->
    <link rel="stylesheet" href="/assets/css/xcs-int/custom.css">
    <link rel="stylesheet" href="/assets/css/xcs-int/elements.css">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/modern-vertical/style.css">
    <!-- End layout styles -->

    <!-- XCS-Int Favicon -->
    <link rel="shortcut icon" href="/assets/images/xcs-int/{{ $constants['global']['application_favicon'] }}" />
    <!-- endfavicon -->

  </head>

<!-- WEB APPLICATION BEGIN -->
  <body>

    <div class="container-scroller">

      <!-- partial:master/sidebar.blade.php -->
      @include('master.sidebar')
      <!-- endpartial -->

      <div class="container-fluid page-body-wrapper">

        <!-- partial:master/header.blade.php -->
        @include('master.header')
        <!-- endpartial -->

        <div class="main-panel">

        @if($constants['announcement']['enabled'] && $constants['announcement']['visible']['main_application'])
        <!-- main-panel-announcement begins -->
        <div class="main-panel-announcement bg-{{ $constants['announcement']['content']['background-color'] }}">
          @if($constants['announcement']['content']['icon'])
          <i class="{{ $constants['announcement']['content']['icon'] }}"></i> 
          @endif
          {{ $constants['announcement']['content']['content'] }}
        </div>
        <!-- main-panel-announcement ends -->
        @endif

          <!-- content-wrapper begins -->
          @yield('content')
          <!-- content-wrapper ends -->

          <!-- partial:master/footer.blade.php -->
          @include('master.footer')
          <!-- endpartial -->

        </div>
        <!-- main-panel ends -->

      </div>
      <!-- page-body-wrapper ends -->

    </div>

    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/vendors/moment/moment.min.js"></script>
    <script src="/assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/select2/select2.min.js"></script>
    <script src="/assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
    <script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="/assets/vendors/sweetalert/sweetalert.min.js"></script>
    <script src="/assets/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    @yield('pluginjs')
    <!-- endinject -->

    <!-- inject:js -->
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/js/notifications.js"></script>
    @yield('injectjs')
    <!-- endinject -->

    <!-- Global modals for this page-->
    @include('modals.submit_patrol_log_modal')
    @include('modals.submit_absence_modal')
    <!-- End global modals for this page-->

    <!-- Modals for this page-->
    @yield('modals')
    <!-- End modals for this page -->

    <!-- XCS-Int Javascript-->
    <script src="/js/app.js"></script>
    <!-- End XCS-Int Javascript-->

  </body>
</html>
<!-- WEB APPLICATION END -->