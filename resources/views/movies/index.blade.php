@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-10 col-md-offset-1">
	        	<header>
					<h1>
						Movies
					</h1>
				 	<hr>
	        	</header>
	        	@role('admin')
					@if ($movies->count() > 0)
						<form action="{{ url('/movies/form') }}" method="POST">
							{{ csrf_field() }}
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>Name</th>
										<th>Year</th>
										<th>Watched</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($movies as $movie)
										<tr>
											<td><input type="checkbox" name="movie_ids[]" value="{{$movie->id}}"></td>								
											<td><a href="{{url("/movies/{$movie->id}")}}">{{ $movie->name }}</a></td>
											<td>{{ $movie->year }}</td>
											<td>{{ $movie->watched }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<input type="submit" class="btn btn-default" name="action_assign" value="Assign to User">
							<input type="submit" class="btn btn-danger" name="action_delete" value="Delete">
						</form>
					@else
						<p>Nothing to show.</p>
					@endif
				@else
					<p>No movies to show.</p>
				@endrole
				<br>
				@include('files.partials.form')
			</div>
		</div>
	</div>
@endsection