@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
				@if(count($applications))
					<h1>{{ count($applications) }} Applications</h1>
					<hr>
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Company</th>
								<th>Disciplines</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($applications as $applicant)
								<tr>
									<td><a href="{{ url("/applications/{$applicant->id}")}}">{{ $applicant->name }}</a></td>
									<td><a href="{{ $applicant->website }}">{{ $applicant->company }}</a></td>
									<td>
										<ul class="list-unstyled">
											@foreach ($applicant->disciplines as $discipline)
											<li>{{ $discipline }}</li>
											@endforeach
										</ul>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<h1>Applications</h1>
					<hr>
					<p>No applications yet.</p>
				@endif
			</div>
		</div>
	</div>
@endsection