@extends('layouts.app')

@section('content')
	<div class="container-fluid submissions">
	    <div class="row">
	    	<div class="col-md-2 filter-sidebar">
	    		<ul class="list-unstyled submission-filters">
	    			<li><a href="#" class="active">All Submissions <small>(245)</small></a></li>
	    			<li><a href="#">Shortlisted <small>(67)</small></a></li>
	    		</ul>
	    	</div>
	        <div class="col-md-10 submissions-body">
	        	<div class="container-fluid">
	        		<header class="submission__header clearfix">
	        			<h1 class="submission__heading pull-left">{{$application->company}}</h1>
	        			@if ($previous || $next)
		        			<ul class="list-inline pull-right">
		        				@if ($previous)
			        				<li><a href="{{url("/users/{$previous}")}}">Previous</a></li>
			        			@endif
			        			@if($next)
			        				<li><a href="{{url("/users/{$next}")}}">Next</a></li>
			        			@endif
		        			</ul>
	        			@endif
	        		</header>
					@include('applications.partials.data')
					@include('applications.partials.ratings')
	        	</div>
			</div>
		</div>
	</div>
@endsection


