<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<meta name="theme-color" content="#3D3B56">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title class="apptitle">
		@hasSection('title')
			@yield('title') |
		@endif
		{{ config('app.name') }}
	</title>

	<meta name="author" content="{{ config('config.copyright.name') }} <{{ config('config.copyright.url') }}>">

	<!--begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            },
        });
	</script>
	<!--end::Web font -->

	<!-- Styles -->
	<link rel="stylesheet" href="{{ mix('css/vendor.css', 'admin') }}">
	<link rel="stylesheet" href="{{ mix('css/theme.css', 'admin') }}">
	<link rel="stylesheet" href="{{ mix('css/dashboard-app.css', 'admin') }}">
	<link rel="stylesheet" href="{{ mix('css/app.css', 'admin') }}">

	@stack('css')
</head>
<body class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default">

<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<main id="app" class="m-grid m-grid--hor m-grid--root m-page">

	@include('admin.partials.header')

	<div class="main-wrap">
		<div class="main-wrap-inner">

			<div class="action-btn">
				@yield('action-button')
			</div>

			<div class="main-content">
				<div id="app">
					<alert-notification errors-notification="{{ $errors }}"
										flash="{{ session()->get('flash_notification') }}"></alert-notification>
					@yield('content')
				</div>
			</div>

		</div>
	</div>
</main>

<!-- <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
	<i class="la la-arrow-up"></i>
</div> -->

<script src="{{ mix('js/manifest.js', 'admin') }}"></script>
<script src="{{ mix('js/vendor.js', 'admin') }}"></script>
<script src="{{ mix('js/theme.js', 'admin') }}"></script>
<script src="{{ mix('js/app.js', 'admin') }}"></script>

</body>
</html>
