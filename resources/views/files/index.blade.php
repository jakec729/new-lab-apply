@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
				<h1>Files</h1>
				@if($files->count() > 0)
				<table class="table">
					<tr>
						<th>Name</th>
						<th>Url</th>
						<th>Created</th>
					</tr>
					@foreach($files as $file)
						<tr>
							<td><a href="{{ url("/files/{$file->id}") }}">{{ $file->name }}</a></td>
							<td>{{ $file->url }}</td>
							<td>{{ $file->created_at }}</td>
						</tr>							
					@endforeach
				</table>
				@else
					<p>No files yet.</p>
				@endif
			</div>
		</div>
	</div>
@endsection