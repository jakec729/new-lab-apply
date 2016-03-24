<div class="col-md-7 submission-data">
	<section class="app__extra clearfix">
		<div class="pull-left">
			<h4>Contact</h4>
			<address>
				<strong>{{$application->name}}</strong><br>
				<a href="mailto:{{$application->email}}">{{$application->email}}</a>
			</address>
		</div>
		<div class="app__links pull-left">
			<h4>Links</h4>
			<ul class="list-unstyled">
				<li><a href="{{$application->website}}">{{$application->website}}</a></li>
				@if($application->link_1)
					<li><a href="{{$application->link_1}}">{{$application->link_1}}</a></li>
				@endif
				@if($application->link_2)
					<li><a href="{{$application->link_2}}">{{$application->link_2}}</a></li>
				@endif
			</ul>
		</div>
	</section>
	<section id="app__ribbon" class="clearfix">
		<div class="item">
			<strong>No. of Employees</strong><br>
			{{$application->desks}}
		</div>
		<div class="item">
			<strong>Membership</strong><br>
			{{$application->membership_type}}
		</div>
		<div class="item">
			<strong>Discipline</strong><br>
			{{$application->discipline}}
		</div>
	</section>
	<section class="app__texts">
		<div class="text">
			<h4 class="text-heading">Elevator Pitch</h4>
			<p>{{$application->text_pitch}}</p>
		</div>

		<div class="text">
			<h4 class="text-heading">Technology</h4>
			<p>{{$application->text_tech}}</p>
		</div>

		<div class="text">
			<h4 class="text-heading">Team</h4>
			<p>{{$application->text_team}}</p>
		</div>
		
		<div class="text">
			<h4 class="text-heading">Funding Stage</h4>
			<p>{{$application->funding_stage}}</p>
		</div>
		
		<div class="text">
			<h4 class="text-heading">What New Lab resources would be most beneficial to you?</h4>
			<ul class="list-unstyled">
				@foreach($application->resources() as $r)
					<li>{{$r}}</li>
				@endforeach
			</ul>
		</div>
		
		<div class="text">
			<h4 class="text-heading">Why New Lab?</h4>
			<p>{{$application->text_community}}</p>
		</div>
		
		<div class="text">
			<h4 class="text-heading">Additional Message</h4>
			<p>{{$application->additional_message}}</p>
		</div>
	</section>
</div>