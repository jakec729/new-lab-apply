@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
				<h1>Users</h1>
				@if($users->count() > 0)
				<table class="table">
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Created</th>
					</tr>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->created_at }}</td>
						</tr>							
					@endforeach
				</table>
				@else
					<p>No users yet.</p>
				@endif
			</div>
		</div>
	</div>
@endsection