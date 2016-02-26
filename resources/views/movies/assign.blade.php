@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-10 col-md-offset-1">
				<h1>Assign {{ count($movies) }} Movies to...</h1>
			 	<hr>
			 	<div class="row">
				 	<div class="movies col-md-4">
					 	<p><strong>Movies</strong></p>
					 	<ul class="list-group">
					 	@foreach( $movies as $movie )
					 		<li class="list-group-item"> 
					 			{{ $movie->name }}
					 		</li>
					 	@endforeach
					 	</ul>
				 	</div>

					<div class="users col-md-7 col-md-offset-1">
					 	<p><strong>Users</strong></p>
					 	@foreach( $users as $user )
					 		<p> {{ $user->name }}</p>
					 	@endforeach
					</div>
			 	</div>
			</div>
		</div>
	</div>
@endsection