@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-10 col-md-offset-1">
				<h1>Review Applications</h1>
			 	<hr>
				@if ($applications)
					<form action="{{ url('/files') }}" method="POST">
					<input type="hidden" name="file" value="{{ serialize($applications->toArray()) }}">
					{{ csrf_field() }}
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Email</th>
								<th>Company</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($applications as $key => $application)
								<tr>
									<td><input type="checkbox" name="application_keys[]" id="application_keys[]" value="{{ $key }}" checked></td>									
									<td>{{ $application->name }}</td>
									<td>{{ $application->email }}</td>
									<td>{{ $application->company }}</td>
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