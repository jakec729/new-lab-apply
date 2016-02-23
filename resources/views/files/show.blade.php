@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-10 col-md-offset-1">
				<h1>{{ $file->name }}</h1>
				<small>{{ $file->url }}</small>
			 	<hr>
				@if ($results)
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Year</th>
								<th>Watched</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($results as $movie)
								<tr>									
									<td>{{ $movie["Movie"] }}</td>
									<td>{{ $movie["Year"] }}</td>
									<td>{{ $movie["Watched"] }}</td>
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