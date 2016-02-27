@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
				@if(count($applications))
					<a href="{{ url("/applications/download") }}" class="btn btn-primary">Download CSV</a>
					<a href="{{ url("/files/import") }}" class="btn btn-default">Import CSV</a>
					<h1>{{$total}} Applications <small>{{count($applications)}} Shown</small></h1>
					<hr>
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Company</th>
								<th>Funding Stage</th>
								<th>Rating</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($applications as $applicant)
								<tr>
									<td><a href="{{ url("/applications/{$applicant->id}")}}">{{ $applicant->name }}</a></td>
									<td><a href="{{ $applicant->website }}">{{ $applicant->company }}</a></td>
									<td>{{$applicant->funding_stage }}</td>
									<td>{{$applicant->rating }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{!! $applications->links() !!}
				@else
					<h1>Applications</h1>
					<hr>
					<p>No applications yet.</p>
				@endif
			</div>
		</div>
	</div>
@endsection