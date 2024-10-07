<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>403 | {{ config('app.name') }} - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('public/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('public/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center pt-4">
                            <div class="">
                                <img src="{{ asset('public/assets/images/error.svg') }}" alt="" class="error-basic-img move-animation">
                            </div>
                            <div class="mt-n4">
                                <h1 class="display-1 fw-medium">403</h1>
                                <h3 class="text-uppercase">Sorry, You are not allowed to access this resource 😭</h3>
                                <p class="text-muted mb-4">The page you are looking for not available!</p>
                                <a href="#" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Back to home</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                Crafted with <i class="mdi mdi-heart text-danger"></i> by Digitalogies
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins.js') }}"></script>

    <!-- particles js -->
    <script src="{{ asset('public/assets/libs/particles.js') }}/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{ asset('public/assets/js/pages/particles.app.js') }}"></script>

</body>

</html>