@extends('layouts.submission')

@section('title', 'All Users')

@section('controls')
	@permission('create.users')
		<a href="{{url('/register')}}" class="btn btn-default">Register New Users</a>
	@endpermission
@endsection

@section('body')
	@if(count($users))
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Created</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td><a href="{{url("/users/{$user->id}")}}">{{ $user->name }}</a></td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->listRoles() }}</td>
						<td>{{ $user->created_at->format('Y-m-d') }}</td>
					</tr>							
				@endforeach
			</tbody>
		</table>
	@else
		<p>No users yet.</p>
	@endif
@endsection

