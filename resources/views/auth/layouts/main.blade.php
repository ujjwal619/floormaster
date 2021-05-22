<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>
		@hasSection('title')
			@yield('title') |
		@endif
		{{ config('app.name') }}
	</title>
	
	<!-- Styles -->
	<link rel="stylesheet" href="{{ mix('css/app.css', 'auth') }}">
	@stack('css')
</head>
<body>

<main id="app" class="container">
	<section class="login-container">
		<div class="wrapper">
			@yield('content')
		</div>
	</section>
</main>

<!-- Scripts -->
<script src="{{ mix('js/app.js', 'auth') }}"></script>
@stack('scripts')

</body>
</html>
