<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="../image_icon/titellogo.png" type="image/x-icon">

    <link rel="apple-touch-icon" type="image/x-icon" href="{{url('assets/images/apple-touch-icon-57x57-precomposed.png')}}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{url('assets/images/apple-touch-icon-72x72-precomposed.png')}}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{url('assets/images/apple-touch-icon-114x114-precomposed.png')}}">
    <title class="text-uppercase text-success">Hilltourismbd | @yield('title')</title>


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{url('adminassets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{url('adminassets/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{url('adminassets/plugins/animate-css/animate.css')}}" rel="stylesheet" />


     <!-- JQuery DataTable Css -->
    <link href="{{url('adminassets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">


    <!-- Custom Css -->
    <link href="{{url('adminassets/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{url('adminassets/css/themes/all-themes.css')}}" rel="stylesheet" />

</head>

<body class="login-page">

@yield("content")
      

    <!-- Jquery Core Js -->
    <script src="{{url('adminassets/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{url('adminassets/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{url('adminassets/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{url('adminassets/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{url('adminassets/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{url('adminassets/plugins/node-waves/waves.js')}}"></script>

      <!-- Jquery Validation Plugin Css -->
    <script src="{{url('adminassets/plugins/jquery-validation/jquery.validate.js')}}"></script>

      <!-- Sweet Alert Plugin Js -->
    <script src="{{url('adminassets/plugins/sweetalert/sweetalert.min.js')}}"></script>


     <!-- Jquery DataTable Plugin Js -->
    <script src="{{url('adminassets/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{url('adminassets/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- end of data table js -->

    <!-- Custom Js -->
    <script src="{{url('adminassets/js/admin.js')}}"></script>
    <script src="{{url('adminassets/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{url('adminassets/js/pages/forms/form-validation.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{url('adminassets/js/demo.js')}}"></script>
</body>

</html>
