@extends('myapp')

@section('content')
	<section>
		<div class="container-fluid">
			<div class="jumbotron">
				<h1  class="text-info" align="center">MyUsic</h1>
				@if(Auth::check())
					@if (Auth::user()['user'] == $username)
						<div class="col-md-1">
							{{"Welcome ".Auth::user()['user']}}
							<a class="navbar-brand " href="#"></a>
						</div>
					@else
						<div class="col-md-1">
							{{"Viewing ".$username."'s Profile"}}
							<a class="navbar-brand " href="#"></a>
						</div>
					@endif
				@else
					<div class="col-md-1">
						{{"Viewing ".$username."'s Profile"}}
						<a class="navbar-brand " href="#"></a>
					</div>
				@endif
			</div>
			<div class="row">
				<div class="col-sm-4" style="background-color:#696969;">
					<br>

					<div class="col-md-10 col-md-offset-1">
						<a href="userprofile" class="thumbnail" >
							@if( empty(Auth::user()->profile->profile_picture))
								<img class="img-responsive" src="/img/icon.png" alt="">
							@else
								<img class="avatar" src="/image" />
							@endif
						</a>
						<strong class="name"></strong>
						<span class="button following">Following</span>
						<br>
						<br>
						<button type="button" class="btn btn-primary"><a href="/playlists">Playlists</a></button>
						<br>
						<br>
						<button type="button" class="btn btn-danger"><a href="/tracks">Tracks</a></button>
						<br>
						<br>
					</div>
					<br>
				</div>
				<div class="col-sm-6" style="background-color:;">
					<h2>My Tracks</h2>
					<table class="table table-condensed">
						<thead>
							<th>Artist/Band</th>
							<th>Track Name</th>
							<th>Genre</th>
						</thead>
						@foreach($data as $track)
                            <tr>
                                <td>{{ $track->authors }}</td>
                                <td>{{ $track->song_name }}</td>
                                <td>{{ $track->genre }}</td>
								@if(Auth::check())
                                	<td><audio controls> <source src="{{ "/audio/".$track->id }}" type="audio/mpeg">Your browser does not support the audio element.</audio></td>
								@else
									<td></td>
								@endif
                            </tr>
                        @endforeach
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection