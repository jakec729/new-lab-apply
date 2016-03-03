@extends('layouts.app')

@section('content')
	<div class="container-fluid submissions">
	    <div class="row">
	    	<div class="col-md-2 filter-sidebar">
	    		<ul class="list-unstyled submission-filters">
	    			<li><a href="#" class="active">All Submissions <small>({{$total}})</small></a></li>
	    			<li><a href="#">Shortlisted <small>({{$shortlisted->count()}})</small></a></li>
	    		</ul>
	    	</div>
	        <div class="col-md-10 submissions-body">
	        	<div class="container-fluid">
				@if(count($applications))
		        	<div class="row">
						<div class="col-md-7">
							<h1>All Submissions</h1>
						</div>
						<div class="col-md-5 submission-controls">
							<ul class="list-inline">
								<li>
									<form action="" class="form-inline">
										<div class="form-group">
											<label for="posts_per_page">Show</label>
											<select name="posts_per_page" id="posts_per_page" class="form-control">
												<option value="50">50</option>
												<option value="100">100</option>
												<option value="200">200</option>
											</select>
										</div>
									</form>
								</li>
								<li>{!! $applications->links() !!}</li>
							</ul>
						</div>
					</div>
					<hr>
					<table class="table table-striped" id="submissions-table">
						<thead>
							<tr>
								<th>Date</th>
								<th>Name</th>
								<th>Company</th>
								<th>Discipline</th>
								<th>Size</th>
								<th>Type</th>
								<th>Pitch</th>
								<th>Me</th>
								<th>Avg.</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($applications as $applicant)
								<tr>
									<td>{{$applicant->created_at}}</td>
									<td><a href="{{ url("/applications/{$applicant->id}")}}">{{ $applicant->name }}</a></td>
									<td><a href="{{ $applicant->website }}">{{ $applicant->company }}</a></td>
									<td>TBD</td>
									<td>{{$applicant->desks}}</td>
									<td>{{$applicant->membership_type}}</td>
									<td>{{ str_limit($applicant->text_pitch, $limit = 200, $end = '...') }}</td>
									<td>TBD</td>
									<td>{{$applicant->rating }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
	        	</div>
				@else
					<h1>Applications</h1>
					<hr>
					<p>No applications yet.</p>
				@endif
			</div>
		</div>
	</div>
@endsection