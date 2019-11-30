<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME', 'CloudComCRM') }}</title>

    <!-- Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google:{ 
                "families": ["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link rel="stylesheet" href="https://keenthemes.com/metronic/preview/demo1/custom/apps/user/assets/css/demo1/pages/general/wizard/wizard-4.css">

    <link rel="stylesheet" href="{{ asset('vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/general/sweetalert2/dist/sweetalert2.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('vendors/custom/jqvmap/jqvmap.bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/general/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/general/socicon/css/socicon.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/custom/vendors/line-awesome/css/line-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/custom/vendors/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/custom/vendors/flaticon2/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/general/@fortawesome/fontawesome-free/css/all.min.css') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    
    <div class="gq-wrapper" id="app">
        <main-app></main-app>
    </div>

    <script>
        const KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                    "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                }
            }
        };
    </script>

    <!-- APP JS -->
    <script src="{{ asset('vendors/general/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('vendors/general/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('vendors/general/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/general/js-cookie/src/js.cookie.js') }}"></script>
    <script src="{{ asset('vendors/general/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}"></script>
    <script src="{{ asset('vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendors/general/sticky-js/dist/sticky.min.js') }}"></script>
    <script src="{{ asset('vendors/general/wnumb/wNumb.js') }}"></script>
    <script src="{{ asset('vendors/general/block-ui/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('vendors/general/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendors/custom/js/vendors/jquery-validation.init.js') }}"></script>
    <script src="{{ asset('vendors/general/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('vendors/custom/js/vendors/bootstrap-notify.init.js') }}"></script>
    <script src="{{ asset('vendors/general/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendors/general/chart.js/dist/Chart.bundle.js') }}"></script>
    <script src="{{ asset('vendors/custom/jqvmap/jqvmap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/metronic.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
