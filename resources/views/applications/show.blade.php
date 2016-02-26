@extends('layouts.app')

@section('content')
	<div class="container">
		<header class="col-md-10 col-md-offset-1">
			<h1>{{$application->name}} <small><a href="{{$application->website}}">{{$application->company}}</a></small></h1>
			<ul class="list-unstyled">
				<li><a href="#">{{$application->email}}</a></li>
			</ul>
			<hr>
		</header>
		<br>
		<div class="col-md-6 col-md-offset-1">
			<section>
				<h3>Elevator Pitch</h3>
				<p>{{$application->text_pitch}}</p>
			</section>
			<hr>
			<section>
				<h3>On Technology</h3>
				<p>{{$application->text_tech}}</p>
			</section>
			<hr>
			<section>
				<h3>On the Founding Team</h3>
				<p>{{$application->text_team}}</p>
			</section>
			<hr>
			<section>
				<h3>On Commercialization Strategy</h3>
				<p>{{$application->text_strategy}}</p>
			</section>
			<hr>
			<section>
				<h3>On the New Lab Community</h3>
				<p>{{$application->text_community}}</p>
			</section>
		</div>
		<br>
		<div class="col-md-4 col-md-offset-1">
			<section>
				<h3 class="h4 strong"><strong>Desks Needed:</strong></h3>
				<p>{{$application->desks}}</p>
				<br>
				<h3 class="h4 strong"><strong>Disciplines:</strong></h3>
				<ul class="list-unstyled">
					@foreach( $application->disciplines as $discipline)
						<li>{{ $discipline }}</li>
					@endforeach
				</ul>
				<br>

				<h3 class="h4 strong"><strong>Type of Membership:</strong></h3>
				<p>{{ $application->membership_type}}</p>
				<br>

				<h3 class="h4 strong"><strong>Funding Stage:</strong></h3>
				<p>{{$application->funding_stage}}</p>
				<br>

				</ul>
			</section>
		</div>
	</div>
@endsection