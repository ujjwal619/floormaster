<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <meta name="theme-color" content="#3D3B56">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
    @hasSection('title')
      @yield('title') |
    @endif
    {{ config('app.name') }}
  </title>

  <meta name="author" content="{{ config('config.copyright.name') }} <{{ config('config.copyright.url') }}>">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/dashboard-vendor.css', 'admin') }}">
  <link rel="stylesheet" href="{{ mix('css/dashboard-app.css', 'admin') }}">


  <link rel="stylesheet" href="{{ mix('css/vendor.css', 'admin') }}">
  <link rel="stylesheet" href="{{ mix('css/theme.css', 'admin') }}">
  <link rel="stylesheet" href="{{ mix('css/app.css', 'admin') }}">
  <style>
    body{
      background-color: black;
    }
  </style>
  @stack('css')
</head>
<body>

<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
  your browser</a> to improve your experience and security.</p>
<![endif]-->

@include('admin.partials.header')

<!--Main Wrapper-->
<main class="main-wrapper">
  <div class="main-wrapper__inner" id="app">

    <!--Hero-banner-->
    <section class="banner">
      <div class="banner__inner">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </section>
    <!--End-Hero-banner-->
  </div>
</main>
<!--End Wrapper-->

<!--Scripts-->

<script src="{{ mix('js/manifest.js', 'admin') }}"></script>
<script src="{{ mix('js/vendor.js', 'admin') }}"></script>
<script src="{{ mix('js/theme.js', 'admin') }}"></script>
<script src="{{ mix('js/app.js', 'admin') }}"></script>
</body>
</html>
