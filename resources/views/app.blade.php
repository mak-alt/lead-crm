<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>CRM | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }} CRM" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <meta content="noindex,nofollow" name="robots" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">

    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/dragula/dragula.min.css') }}" />

    <script src="{{ asset('public/assets/js/layout.js') }}"></script>

    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('public/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    
    @inertiaHead
    @routes
</head>

<body>
    @inertia

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <audio id="ChatAudio">
        <source src="{{asset('public/assets/sound/chat-notify.mp3')}}">
    </audio>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <!-- <script src="{{ asset('public/assets/js/plugins.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('public/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('public/assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- prismjs plugin -->
    <script src="{{ asset('public/assets/libs/prismjs/prism.js') }}"></script>

    <!-- notifications init -->
    <script src="{{ asset('public/assets/js/pages/notifications.init.js') }}"></script>

    <!-- dom autoscroll -->
    <script src="{{ asset('public/assets/libs/dom-autoscroller/dom-autoscroller.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <script>
        
      window.onload = function(e) {
        // var scriptElement=document.createElement('script');
        // scriptElement.type = 'text/javascript';
        // scriptElement.src = "{{ asset('public/assets/js/pages/tasks-kanban.init.js') }}";
        // document.body.appendChild(scriptElement);

        // var date = document.getElementsByClassName('flatpickr-date')
        // flatpickr(date,{
        //   minDate:'today',
        //   dateFormat: "Y-m-d",
        // })
      }
      window._asset = '{{ asset('') }}';
    </script>
  </body>
</html>

