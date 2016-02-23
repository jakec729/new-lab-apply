@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
				<h1>Roles</h1>
				@if($roles->count() > 0)
				<table class="table">
					<tr>
						<th>Name</th>
						<th>Slug</th>
						<th>Created</th>
					</tr>
					@foreach($roles as $role)
						<tr>
							<td>{{ $role->name }}</td>
							<td>{{ $role->slug }}</td>
							<td>{{ $role->created_at }}</td>
						</tr>							
					@endforeach
				</table>
				@else
					<p>No roles yet.</p>
				@endif
			</div>
		</div>
	</div>
@endsection