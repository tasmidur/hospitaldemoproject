<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard analytics - Vuexy - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="{{url('dashboard-asset/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('dashboard-asset/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/vendors/css/extensions/tether-theme-arrows.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/vendors/css/extensions/tether.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/vendors/css/extensions/shepherd-theme-default.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/pages/dashboard-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/pages/card-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/css/plugins/tour/tour.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/style.css')}}">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Vendor CSS-->
  
    <link rel="stylesheet" type="text/css" href="{{url('dashboard-asset/vendors/css/tables/datatable/datatables.min.css')}}">
    <!-- END: Vendor CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="dark-layout">

    <!-- BEGIN: Upper Header-->
    @include('Menu.uppersideheader')
    <!-- END: Upper Header-->


    <!-- BEGIN: Left Menu-->
     @include('Menu.leftsidemenu')
    <!-- END: Left Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
             
                @yield('content');

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2019<a class="text-bold-800 grey darken-2" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i class="feather icon-heart pink"></i></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{url('dashboard-asset/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{url('dashboard-asset/vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{url('dashboard-asset/vendors/js/extensions/tether.min.js')}}"></script>
    <script src="{{url('dashboard-asset/vendors/js/extensions/shepherd.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{url('dashboard-asset/js/core/app-menu.js')}}"></script>
    <script src="{{url('dashboard-asset/js/core/app.js')}}"></script>
    <script src="{{url('dashboard-asset/js/scripts/components.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{url('dashboard-asset/js/scripts/pages/dashboard-analytics.js')}}"></script>
    <!-- END: Page JS-->

     <!-- BEGIN: Datatable JS-->
    
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/datatables.min.js')}}"></script>
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
     <script src="{{url('dashboard-asset/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
     <script src="{{url('dashboard-asset/js/scripts/datatables/datatable.js')}}"></script>
     <!-- END: Datatable JS-->

     {{-- BEGIN Custom Js --}}

     @yield("userjs")
     @yield("permissionjs")
     @yield("rolejs")

     {{-- END:Customjs --}}


 

</body>
<!-- END: Body-->

</html>