@extends('layouts.submission')

@section('title', $application->company)

@section('controls')
	@if ($previous || $next)
		<ul class="list-inline">
			@if ($previous)
				<li><a href="{{url("/applications/{$previous}")}}"><i class="fa fa-fw fa-chevron-left"></i> Previous</a></li>
			@endif
			@if($next)
				<li><a href="{{url("/applications/{$next}")}}">Next <i class="fa fa-fw fa-chevron-right"></i></a></li>
			@endif
		</ul>
	@endif
@endsection

@section('body')
	@include('applications.partials.data')
	<div class="col-md-5 submission-ratings">
	    <div class="inner">
			@include('applications.partials.ratings')
			@include('applications.partials.comments')
		</div>
		<footer class="text-right sidebar__footer">
		    <a href="#app-layout">Back to top <i class="fa fa-arrow-up"></i></a>
		</footer>
	</div>
@endsection