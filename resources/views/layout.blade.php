<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset("assets/images/favicon.ico")}}">

    <!-- App css -->
    <link href="{{asset("assets/css/app.min.css")}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{asset("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />

</head>

<!-- body start -->
<body data-menu-color="light" data-sidebar="default">

<!-- Begin page -->
<div id="app-layout">


    <!-- Topbar Start -->
    @include('components.header')
    <!-- end Topbar -->

    <!-- Left Sidebar Start -->
    @include('components.sidebar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <!-- content -->
        @yield('page')
        <!-- Footer Start -->
        @include('components.footer')
        <!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Vendor -->
<script src="{{asset("assets/libs/jquery/jquery.min.js")}}"></script>
<script src="{{asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("assets/libs/simplebar/simplebar.min.js")}}"></script>
<script src="{{asset("assets/libs/node-waves/waves.min.js")}}"></script>
<script src="{{asset("assets/libs/waypoints/lib/jquery.waypoints.min.js")}}"></script>
<script src="{{asset("assets/libs/jquery.counterup/jquery.counterup.min.js")}}"></script>
<script src="{{asset("assets/libs/feather-icons/feather.min.js")}}"></script>

<!-- Apexcharts JS -->
<script src="{{asset("assets/libs/apexcharts/apexcharts.min.js")}}"></script>

<!-- for basic area chart -->
<script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>

<!-- Widgets Init Js -->
<script src="{{asset("assets/js/pages/analytics-dashboard.init.js")}}"></script>

<!-- App js-->
<script src="{{asset("assets/js/app.js")}}"></script>

</body>
</html>
