@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-10 col-md-offset-1">
				<h1>{{$movie->name}}</h1>
				<hr>
				<dl>
					<dt>Year</dt>
					<dd>{{$movie->year}}</dd>
					<dt>Watched</dt>
					<dd>{{$movie->watched}}</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h3>Comments</h3>
				@if (count($movie->comments))
				<ul class="list-unstyled">
					@foreach ($movie->comments as $comment)
					<li>
						<p><strong>{{ $comment->user->name }}</strong></p>
						<p>{{ $comment->body }}</p>
					</li>
					@endforeach
				</ul>
				@else
					<p>No comments to show.</p>
				@endif
				<hr>
				<div class="comment-form">
					<p><strong>Add a Comment</strong> as <mark>{{ Auth::user()->name }}</mark></p>
					<form action="{{ url("movies/{$movie->id}/comments/create") }}" method="POST">
						{{ csrf_field() }}
						<div class="form-group">
							<textarea name="body" id="comment-body" rows="10" class="form-control"></textarea>
						</div>
						<button class="btn btn-primary">Add Comment</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection