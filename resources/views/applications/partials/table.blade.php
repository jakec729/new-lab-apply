@if($applications->count() > 0)
<form action="" method="GET">
<table class="table table-striped" id="submissions-table">
	<thead>
		<tr>
			<th>
				<label for="tableSortBy_date"><i class="fa fa-sort"></i>&ensp;Date</label>
				<input type="checkbox" name="tableSortBy" id="tableSortBy_date" value="submitted_on" onchange="this.form.submit()"></input>
			</th>
			<th>
				<label for="tableSortBy_name"><i class="fa fa-sort"></i>&ensp;Name</label>
				<input type="checkbox" name="tableSortBy" id="tableSortBy_name" value="last_name" onchange="this.form.submit()"></input>
			</th>
			<th>
				<label for="tableSortBy_company"><i class="fa fa-sort"></i>&ensp;Company</label>
				<input type="checkbox" name="tableSortBy" id="tableSortBy_company" value="company" onchange="this.form.submit()"></input>
			</th>
			<th class="hidden-xs hidden-sm hidden-md">
				<label for="tableSortBy_discipline"><i class="fa fa-sort"></i>&ensp;Discipline</label>
				<input type="checkbox" name="tableSortBy" id="tableSortBy_discipline" value="discipline" onchange="this.form.submit()"></input>
			</th>
			<th class="hidden-xs hidden-sm hidden-md">
				<label for="tableSortBy_size"><i class="fa fa-sort"></i>&ensp;Size</label>
				<input type="checkbox" name="tableSortBy" id="tableSortBy_size" value="desks" onchange="this.form.submit()"></input>
			</th>
			<th class="hidden-xs hidden-sm hidden-md">
				<label for="tableSortBy_type"><i class="fa fa-sort"></i>&ensp;Type</label>
				<input type="checkbox" name="tableSortBy" id="tableSortBy_type" value="membership_type" onchange="this.form.submit()"></input>
			</th>
			<th>Pitch</th>
			<th class="hidden-xs hidden-sm hidden-md">
				<label for="tableSortBy_me">Me</label>
				<!-- <input type="checkbox" name="tableSortBy" id="tableSortBy_me" value="me" onchange="this.form.submit()"></input> -->
			</th>
			<th>
				<label for="tableSortBy_avg"><i class="fa fa-sort"></i>&ensp;Avg.</label>
				<input type="checkbox" name="tableSortBy" id="tableSortBy_avg" value="average_rating" onchange="this.form.submit()"></input>
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($applications as $applicant)
			<tr>
				<td>{{$applicant->submitted_on->format('m-d-y')}}</td>
				<td><a href="{{url("/applications/{$applicant->id}")}}">{{ $applicant->name }}</a></td>
				<td><a class="link--chevron" href="{{ $applicant->website }}">{{ $applicant->company }}</a></td>
				<td class="hidden-xs hidden-sm hidden-md">{{$applicant->discipline}}</td>
				<td class="hidden-xs hidden-sm hidden-md">{{$applicant->desks}}</td>
				<td class="hidden-xs hidden-sm hidden-md">{{$applicant->membership_type}}</td>
				<td class="hidden-xs hidden-sm hidden-md">{{ str_limit($applicant->text_pitch, $limit = 200, $end = '...') }}</td>
				<td>
					@if ($applicant->alreadyRated())
						@if ($applicant->userRating < 1)
							<i class="fa fa-close"></i>
						@else
							@for ($i = 0; $i < $applicant->userRating; $i++)
						        <i class="fa fa-star"></i>
							@endfor
						@endif
					@else
						Unrated
					@endif
				</td>
				<td>
					@if ($applicant->rating > 0)
						@for ($i = 0; $i < $applicant->rating; $i++)
					        <i class="fa fa-star"></i>
						@endfor
					@else
						Unrated
					@endif

				</td>
			</tr>
		@endforeach
	</tbody>
</table>
</form>
@else
	<br>
	<p>No Applications to show.</p>
@endif