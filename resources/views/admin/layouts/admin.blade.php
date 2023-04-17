
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>eCommerce.ir - @yield('title')</title>



    <!-- Custom styles for this template-->
    <link href="{{asset('/css/admin.css')}}" rel="stylesheet">
    @yield('styles')

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('admin.sections.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('admin.sections.topbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
       @include('admin.sections.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

@include('admin.sections.scroll_to_top')


<!-- Custom fronts for this template-->
<script src="{{asset('/fronts/admin.fronts')}}"></script>
@include('sweetalert::alert')

@yield('scripts')

</body>

</html>
