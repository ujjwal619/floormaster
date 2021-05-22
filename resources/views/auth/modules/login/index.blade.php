@extends('auth.layouts.main')

@section('title', 'Login')

@section('content')
	<div id="form" class="animated slideInDown form">
		{!! Form::open([
			'route' => 'auth.login.post',
			'method' => 'post',
			'id' => 'login-form',
			'role' => 'form',
			'autocomplete' => 'on'
		]) !!}
		
		<img src="{{asset('images/cronulla-logo.png')}}" style="padding-left: 142px;">
		
		@if($errors->has('login_error'))
			<div class="alert alert-danger animated fade">
				<strong>Sorry!</strong> {{ $errors->first('login_error') }}
			</div>
		@endif
		
		<p>
			{!! Form::label('username', ' Your username ', [
				'data-icon' => 'u',
			]) !!}
			
			{!! Form::text('username', null, [
				'id' => 'username',
				'placeholder' => 'myusername',
				'class' => $errors->has('username') ? 'has-error' : '',
			]) !!}
			
			<span class="form-error">{{ $errors->first('username') }}</span>
		</p>
		
		<p>
			{!! Form::label('password', ' Your password ', [
				'data-icon' => 'p',
			]) !!}
			
			{!! Form::password('password', [
				'id' => 'password',
				'placeholder' => 'eg. X8df!90EO',
				'class' => $errors->has('password') ? 'has-error' : '',
			]) !!}
			
			<span class="form-error">{{ $errors->first('password') }}</span>
		</p>
		
		<p class="keeplogin">
			{!! Form::checkbox('remember', true, old('remember'), [
				'id' => 'remember'
			]) !!}
			
			{!! Form::label('remember', 'Keep me logged in') !!}
		</p>
		
		<p class="login button">
			<input type="submit" value="Login"/>
		</p>
		
		<!-- <p class="change_link">
			Forget password ?
			<a href="#forget-password">Reset</a>
		</p> -->
		
		{!! Form::close() !!}
	</div>
@endsection
