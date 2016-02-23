@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-6 col-md-offset-3">
				<h1>Upload a File</h1>
				<hr>
				<br>
				@include('common.errors')
				<form action={{ url('/files')}} method="POST" enctype="multipart/form-data">
					{!! csrf_field() !!}

					<!-- File Name -->
			        <div class="form-group">
			            <label for="name" class="control-label">File Name</label>
		                <input type="text" name="name" id="name" class="form-control">
			        </div>

					<!-- Upload File -->
			        <div class="form-group">
			            <label for="file" class="control-label">Upload File</label>
		                <input type="file" name="file" id="file" class="form-control">
			        </div>

					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
		</div>
	</div>
@endsection