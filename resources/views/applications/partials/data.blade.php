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
	<section class="app__ribbon clearfix">
		<table class="table">
			<tr>
				<th>No. of Employees</th>
				<th>Membership</th>
				<th>Discipline</th>
			</tr>
			<tr>
				<td>{{$application->desks}}</td>
				<td>{{$application->membership_type}}</td>
				<td>TBD</td>
			</tr>
		</table>
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
		<p>{{$application->new_lab_resources}}</p>

		<h4 class="text-heading">Community</h4>
		<p>{{$application->text_community}}</p>
	</section>
</div>