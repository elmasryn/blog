<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('lang.Admin panel') }} @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (App::isLocale('en'))
    <!-- Font Awesome en-->
    <link rel="stylesheet" href="{{url('')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style en -->
    <link rel="stylesheet" href="{{url('')}}/dist/css/adminlte.min.css">
    @else
    <!-- Font Awesome ar-->
    <link rel="stylesheet" href="{{url('')}}/plugins/fontawesome-free/css/all.min.rtl.css">
    <!-- Theme style ar -->
    <link rel="stylesheet" href="{{url('')}}/dist/css/adminlte.min.rtl.css">
    <link rel="stylesheet" href="{{url('')}}/dist/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{url('')}}/dist/css/custom.css">
    @endif
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{url('')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- fonts -->
    <link href="{{url('')}}/dist/fonts/fonts.googleapis.css" rel="stylesheet">

    <!-- mystyle -->
    <link href="{{ url('css/adminstyle.css') }}" rel="stylesheet">

    @stack('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">