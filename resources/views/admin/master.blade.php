@include('admin.header')

<!-- Navbar -->
@include('admin.navbar')
<!-- /.navbar -->

<!-- Main Sidebar Container -->
@include('admin.sidebar')


<!-- Content Wrapper. Contains page content -->
@yield('content')
<!-- /.content-wrapper -->

@include('admin.footer')
@include('alerts')