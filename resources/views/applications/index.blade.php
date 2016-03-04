@extends('layouts.submission')

@section('title', 'All Submissions')

@section('controls')
	<div>@include('applications.partials.pagination')</div>
	<div>{!! $applications->appends(['posts_per_page' => $pagination])->links() !!}</div>
@endsection

@section('body')
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
					<td>{{$applicant->created_at->format('Y-m-d')}}</td>
					<td><a href="{{ url("/applications/{$applicant->id}")}}">{{ $applicant->name }}</a></td>
					<td><a href="{{ $applicant->website }}">{{ $applicant->company }}</a></td>
					<td>
						@if ($applicant->disciplines)
							<ul class="list-unstyled">
							@foreach( $applicant->disciplines as $d)
								<li>{{$d}}</li>
							@endforeach
							</ul>
						@endif
					</td>
					<td>{{$applicant->desks}}</td>
					<td>{{$applicant->membership_type}}</td>
					<td>{{ str_limit($applicant->text_pitch, $limit = 200, $end = '...') }}</td>
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
@endsection