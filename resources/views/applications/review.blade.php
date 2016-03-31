@extends('layouts.submission')

@section('title', 'Review Import')

@section('body')
	    <div class="row">
	        <div class="col-md-10">
				@if ($applications->count() > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Unique Applications</h2>
						</div>
						<div class="panel-body">
							<form action="{{ url('/files') }}" method="POST">
							<input type="hidden" name="file" value="{{$file}}">
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
						</div>
					</div>
				@endif
				@if ($duplicates->count() > 0)
					<div class="alert alert-danger">
						<p class="page-heading">
							<strong>{{$duplicates->count() }} Duplicate Applications Found</strong> <br>
							Unable to import duplicates at this time.
						</p>
					</div>
				@endif
			</div>
		</div>
@endsection