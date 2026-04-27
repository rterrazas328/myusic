@extends('myapp')

@section('content')
	<section>
		<div class="container-fluid">
			<div class="jumbotron">
				<h1  class="text-info" align="center">MyUsic</h1>
				<div class="col-md-2">
					<h3>Search Results</h3>
					<a class="navbar-brand " href="#"></a>
				</div>
			</div>
			<div class="row">
				<div class="" style="background-color:#696969;">
                    <table class="table table-condensed" style="color: white">
						<thead>
							<th style="text-align: center">Artist/Band</th>
							<th style="text-align: center">Track Name</th>
							<th style="text-align: center">Genre</th>
                            <th style="text-align: center">Link to profile</th>
						</thead>
                        @if ($data == 0 || count($data) == 0)
                            <h2>0 Search Results</h2>
                        @else
                            @foreach($data as $track)
                                <tr>
                                    <td>{{ $track->authors }}</td>
                                    <td>{{ $track->song_name }}</td>
                                    <td>{{ $track->genre }}</td>
                                    <td><a style="color: blue;" href={{"/home/".$track->id}}>profile link</a></td>
                                </tr>
                            @endforeach
                        @endif
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection