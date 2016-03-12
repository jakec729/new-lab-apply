@extends('layouts.submission')

@section('title', 'All Users')

@section('controls')
	@if(Auth::user()->hasRole('admin'))
		<a href="{{url('/register')}}" class="btn btn-default">Register New Users</a>
	@endif
@endsection

@section('body')
	@if(count($users))
		<table class="table">
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Created</th>
			</tr>
			@foreach($users as $user)
				<tr>
					<td><a href="{{url("/users/{$user->id}")}}">{{ $user->name }}</a></td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->created_at->format('Y-m-d') }}</td>
				</tr>							
			@endforeach
		</table>
	@else
		<p>No users yet.</p>
	@endif
@endsection

