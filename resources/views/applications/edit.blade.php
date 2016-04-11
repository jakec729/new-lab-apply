@extends('layouts.submission')
@inject('applications_rep', 'App\Repositories\ApplicationRepository')

@section('title', $application->company)

@section('body')
	<div class="row">
		<div class="col-md-7">
			<form action="" method="POST">
				{{ csrf_field() }}

				<!-- <fieldset> -->
					<!-- <legend>Applicant Information</legend> -->
					<div class="form-group spaced">
						<div class="row">
							<div class="col-md-6">
								<label for="first_name">First Name</label>
								<input type="text" name="first_name" class="form-control" value="{{$application->first_name}}">
							</div>
							<div class="col-md-6">
								<label>Last Name</label>
								<input type="text" name="last_name" class="form-control" value="{{$application->last_name}}">
							</div>
						</div>
					</div>

					<div class="form-group spaced">
						<label>Contact Email</label>
						<input type="email" class="form-control" name="email" value="{{$application->email}}">
					</div>
				<!-- </fieldset> -->

				<!-- <fieldset> -->
					<!-- <legend>Company Information</legend> -->
					<div class="form-group spaced">
						<div class="row">
							<div class="col-md-6">
								<label>Name of Company</label>
								<input type="text" class="form-control" name="company" value="{{$application->company}}">
							</div>
							<div class="col-md-6">
								<label>Company Website</label>
								<input type="text" class="form-control" name="website" value="{{$application->website}}">
							</div>
						</div>
					</div>
					<div class="form-group spaced">
						<label>Related Website</label>
						<input type="text" class="form-control" name="link_1" value="{{$application->link_1}}">
					</div>
					<div class="form-group spaced">
						<label>Related Website</label>
						<input type="text" class="form-control" name="link_2" value="{{$application->link_2}}">
					</div>
					<div class="form-group spaced">
						<label>Desks</label>
						<select name="desks" class="form-control">
							<option {{isSelected($application->desks, "1 Person")}} value="1 Person">1 Person</option>
							<option {{isSelected($application->desks, "2-4")}} value="2-4">2&ndash;4</option>
							<option {{isSelected($application->desks, "10-30")}} value="10-30">10&ndash;30</option>
						</select>
					</div>
					<div class="form-group spaced">
						<label>Discipline</label>
						<select name="discipline" class="form-control">
							@foreach($applications_rep::listDisciplines() as $value)
								<option {{isSelected($application->discipline, $value)}} value="{{$value}}">{{$value}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group spaced">
						<label>Type of Membership</label>
						<select name="membership_type" class="form-control">
							@foreach($applications_rep::listMembershipTypes() as $value)
								<option {{isSelected($application->membership_type, $value)}} value="{{$value}}">{{$value}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group spaced">
						<label>Funding Stage</label>
						<select name="funding_stage" class="form-control">
							@foreach($applications_rep::listFundingStages() as $value)
								<option {{isSelected($application->funding_stage, $value)}} value="{{$value}}">{{$value}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group spaced">
						<label>New Lab Resources</label>
						@foreach($applications_rep::listResources() as $value)
							<div class="checkbox">
								<label><input type="checkbox" name="new_lab_resources[]" value="{{$value}}" {{isChecked(comma_to_array($application->new_lab_resources), $value)}}>{{$value}}</label>
							</div>
						@endforeach
					</div>
					<div class="form-group spaced">
						<label>Pitch Statement</label>
						<textarea name="text_pitch" id="text_pitch" cols="30" rows="10" class="form-control">{{$application->text_pitch}}</textarea>
					</div>
					<div class="form-group spaced">
						<label>Technology</label>
						<textarea name="text_tech" id="text_tech" cols="30" rows="10" class="form-control">{{$application->text_tech}}</textarea>
					</div>
					<div class="form-group spaced">
						<label>Team</label>
						<textarea name="text_team" id="text_team" cols="30" rows="10" class="form-control">{{$application->text_team}}</textarea>
					</div>
					<div class="form-group spaced">
						<label>Additional Message</label>
						<textarea name="additional_message" id="additional_message" cols="30" rows="10" class="form-control">{{$application->additional_message}}</textarea>
					</div>
					<div class="form-group spaced">
						<label>Why New Lab?</label>
						<textarea name="text_community" id="text_community" cols="30" rows="10" class="form-control">{{$application->text_community}}</textarea>
					</div>
				<!-- </fieldset> -->

				<div class="form-group spaced">
					<button class="btn btn-primary">Save Changes</button>
				</div>

			</form>
		</div>
	</div>
@endsection