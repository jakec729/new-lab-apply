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
	    	<section>
	    		<h4>Criteria</h4>
				<ul class="list--pluses list-unstyled">
					<li>High Impact Technology</li>
					<li>Hardware Centric</li>
					<li>Strong Founding Team</li>
					<li>Scalability</li>
					<li>Investment Potential</li>
					<li>Benefits from NL Resources</li>
					<li>Validated Business Model</li>
					<li>Diversity</li>
				</ul>
	    	</section>
			@include('applications.partials.ratings')
			@include('applications.partials.comments')
		</div>
		<footer class="text-right sidebar__footer">
		    <a href="#app-layout">Back to top <i class="fa fa-arrow-up"></i></a>
		</footer>
	</div>
@endsection