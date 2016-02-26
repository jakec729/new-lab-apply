@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
				@if(count($users))
					<h1>{{ count($users) }} Users</h1>
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
					<h1>Users</h1>
					<p>No users yet.</p>
				@endif
			</div>
		</div>
	</div>
@endsection