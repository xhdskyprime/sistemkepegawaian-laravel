<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/a04c334c80.js" crossorigin="anonymous"></script>

    <!-- CSS Files -->
    <link href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">

    {{-- Sidebar --}}
    @include('layouts.navbars.auth.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        {{-- Navbar --}}
        @include('layouts.navbars.auth.nav')

        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
    <script src="{{ asset('soft-ui-dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('soft-ui-dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('soft-ui-dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('soft-ui-dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('soft-ui-dashboard/assets/js/soft-ui-dashboard.min.js?v=1.0.7') }}"></script>


    @yield('scripts')
</body>
<!-- Fixed Plugin (Configurator) -->
<div class="fixed-plugin">
  <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
    <i class="fa fa-cog py-2"> </i>
  </a>
  <div class="card shadow-lg">
    <div class="card-header pb-0 pt-3">
      <div class="float-start">
        <h5 class="mt-3 mb-0">Soft UI Configurator</h5>
        <p>See our dashboard options.</p>
      </div>
      <div class="float-end mt-4">
        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
          <i class="fa fa-close"></i>
        </button>
      </div>
    </div>
    <hr class="horizontal dark my-1">
    <div class="card-body pt-sm-3 pt-0 overflow-auto">
      <!-- Contoh pengaturan -->
      <div class="mt-3">
        <h6 class="mb-0">Sidebar Type</h6>
        <p class="text-sm">Choose between different sidebar types.</p>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 ms-2">Dark</button>
        </div>
      </div>
      <!-- Anda bisa lanjutkan dengan pengaturan lain seperti dark mode, navbar fixed, dsb -->
    </div>
  </div>
</div>


</html>
