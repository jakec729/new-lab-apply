@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-10 col-md-offset-1">
				<h1>Movies</h1>
			 	<hr>
				@if ($movies)
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Year</th>
								<th>Watched</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($movies as $movie)
								<tr>									
									<td>{{ $movie->name }}</td>
									<td>{{ $movie->year }}</td>
									<td>{{ $movie->watched }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<p>Nothing to show.</p>
				@endif
			</div>
		</div>
	</div>
@endsection