<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset("assets/images/favicon.ico")}}">

    <!-- Datatables css -->
    <link href="{{asset("assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css")}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- App css -->
    <link href="{{asset("assets/css/app.min.css")}}" rel="stylesheet" type="text/css" id="app-style"/>

    <!-- Icons -->
    <link href="{{asset("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css"/>

    {{--  Toastr  --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
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

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('assets/js/code.js') }}"></script>

<!-- App js-->
<script src="{{asset("assets/js/app.js")}}"></script>

{{-- Toastr --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch (type) {
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>

<!-- Datatables js -->
<script src="{{asset("assets/libs/datatables.net/js/jquery.dataTables.min.js")}}"></script>

<!-- dataTables.bootstrap5 -->
<script src="{{asset("assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js")}}"></script>
<script src="{{asset("assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js")}}"></script>
<!-- Datatable Demo App Js -->
<script src="{{asset("assets/js/pages/datatable.init.js")}}"></script>
</body>
</html>
