<!DOCTYPE html>

<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $constants['global']['application_name'] }} :: {{ $constants['pages'][$page_name] }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/fontawesome-free/css/all.min.css">
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
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/xcs-int/custom.css">
    <link rel="stylesheet" href="/assets/css/modern-horizontal/style.css">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="/assets/images/xcs-int/{{ $constants['global']['application_favicon'] }}" />

  </head>

  <body>

    <div class="container-scroller">

      <!-- partial:header -->
      <div class="horizontal-menu">
        @include('public.layouts.header')
        @include('public.layouts.navbar')
      </div>
      <!-- end:partial -->

        @if($constants['announcement']['enabled'] && $constants['announcement']['visible']['public_roster'])
        <!-- main-panel-announcement begins -->
        <div class="main-panel-announcement bg-{{ $constants['announcement']['content']['background-color'] }}">
          <div class="container">
          @if($constants['announcement']['content']['icon'])
          <i class="{{ $constants['announcement']['content']['icon'] }}"></i> 
          @endif
          {{ $constants['announcement']['content']['content'] }}
          </div>
        </div>
        <!-- main-panel-announcement ends -->
        @endif

      <div class="container-fluid page-body-wrapper">

        @yield('content')
        @include('public.layouts.footer')

      </div>

    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    @yield('injectjs')
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>