@extends('layouts.submission')

@section('title', 'All Submissions')

@section('controls')
@endsection

@section('body')
        <div class="col-md-6 col-md-offset-3">
        	<header class="page-header">
				<h1>Hello, {{ $user->name }}</h1>
				<p><a href="mailto:{{$user->email}}">{{$user->email}}</a></p>
        	</header>
        	<section>
        		<h4>Update Role</h4>
        		@include('common.errors')
        		<form action="/users/{{$user->id}}" class="form auth--panel" method="POST">
        			{{csrf_field()}}
        			<div class="form-group">
	        			<select name="user_roles" id="user_roles" class="form-control">
	        				@foreach($roles as $role)
	        					<option value="{{$role->slug}}"
	        					 @if($user->hasRole($role->slug))
	        					 	{{"selected"}}
	        					 @endif
	        					>
	        						{{$role->name}}
	        					</option>
	        				@endforeach
	        			</select>
        			</div>
        			<div class="form-group">
        				<input type="submit" class="btn btn-default btn-block" value="Update Role">
        			</div>
        		</form>
        	</section>
			<section>
				<br>
				<h4>Change Password</h4>
				<br>
				@include('common.errors')
				<form action="/users/{{$user->id}}/updatePassword" method="POST" class="form auth--panel">
					{{csrf_field()}}
					<div class="form-group">
						<input class="form-control" type="password" name="password" placeholder="Password">
					</div>
					<div class="form-group">
						<input class="form-control" type="password" name="password_confirm" placeholder="Confirm Password">
					</div>
					<div class="form-group">
						<button class="btn btn-block btn-primary">Update Password</button>
					</div>
				</form>
			</section>
		</div>
@endsection
