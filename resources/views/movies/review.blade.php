@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-10 col-md-offset-1">
				<h1>Review Movies</h1>
			 	<hr>
				@if ($movies)
					<form action="{{ url('/files') }}" method="POST">
					{{ csrf_field() }}
					<input name="file" type="hidden" value="{{ serialize($movies->toArray()) }}">
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
							@foreach ($movies as $key => $movie)
								<tr>
									<td><input type="checkbox" name="movie_keys[]" id="movie_keys[]" value="{{ $key }}"></td>									
									<td>{{ $movie->name }}</td>
									<td>{{ $movie->year }}</td>
									<td>{{ $movie->watched }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<input type="submit" class="btn btn-warning">
					</form>
				@else
					<p>Nothing to show.</p>
				@endif
			</div>
		</div>
	</div>
@endsection