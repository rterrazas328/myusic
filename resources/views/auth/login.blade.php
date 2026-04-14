@extends('myapp')

@section('content')
<div class="container">
	<div class="jumbotron">
		<h1 align="center">Log In To MyUsic Account</h1>
	</div>
</div>
<div class="container-fluid">
	<x-auth-session-status class="mb-4" :status="session('status')" />
	<div class="row">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				Error with username or password<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<form id="form-signin_v1" name="form-signin_v1" action="{{ route('login') }}" method="post" align="center" class="form-horizontal col-md-4 col-md-offset-4">
			@csrf
			<input type="hidden" name="honeypot" value="IS-421-RRZ" />
			<label>
				Username
				&nbsp;
				<input name="user" id="user" value="{{ old('user') }}" type="text" data-validation="[NOTEMPTY]"  class="form-control">
			</label>
			<br>
			<label>
				Password
				&nbsp;
				<input name="password" id="password" type="password" data-validation="[NOTEMPTY]"  class="form-control">
			</label>
			<br>
			<button type="submit" class="btn btn-primary btn-lg active">{{ __('Log in') }}</button>
			<button  type="button" class="" onClick="parent.location='register'">{{ __('Sign up') }}</button>
			<p>
			</p>
			<br>
			<p class="">
				<a href="{{ route('username.request') }}">
					{{ __('Forgot your username?') }}
				</a>
				<p class="">
					<a href="{{ route('password.request') }}">
						{{ __('Forgot your password?') }}
					</a>
				</p>
			</p>
		</form>
	</div>
</div>
@endsection
