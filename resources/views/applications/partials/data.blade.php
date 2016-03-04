<div class="col-md-7 submission-data">
	<section class="app__extra clearfix">
		<div class="pull-left">
			<h4>Contact</h4>
			<address>
				<strong>{{$application->name}}</strong><br>
				<a href="mailto:{{$application->email}}">{{$application->email}}</a>
			</address>
		</div>
		<div class="pull-left">
			<h4>Links</h4>
			<ul class="list-unstyled">
				<li><a href="#">www.honeybeerobotics.com</a></li>
				<li><a href="#">www.honeybeerobotics.com</a></li>
				<li><a href="#">www.honeybeerobotics.com</a></li>
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
			@if ($application->disciplines)
				<ul class="list-unstyled">
				@foreach( $application->disciplines as $d)
					<li>{{$d}}</li>
				@endforeach
				</ul>
			@endif
		</div>
	</section>
	<section class="app__texts">
		<h4 class="text-heading">Elevator Pitch</h4>
		<p>{{$application->text_pitch}}</p>

		<h4 class="text-heading">Technology</h4>
		<p>{{$application->text_tech}}</p>

		<h4 class="text-heading">Management Team</h4>
		<p>{{$application->text_team}}</p>

		<h4 class="text-heading">Funding Stage</h4>
		<p>{{$application->funding_stage}}</p>

		<h4 class="text-heading">What New Lab resources would be most beneficial to you?</h4>
		<ul class="list-unstyled">
			@foreach( unserialize($application->new_lab_resources) as $r)
			<li>{{$r}}</li>
			@endforeach
		</ul>

		<h4 class="text-heading">Community</h4>
		<p>{{$application->text_community}}</p>
	</section>
</div>