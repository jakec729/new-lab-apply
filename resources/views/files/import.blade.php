@extends('layouts.app')

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-6 col-md-offset-3">
				<h1>Import CSV</h1>
				<hr>
				<br>
				@include('common.errors')
				<form action={{ url('/files/review')}} method="POST" enctype="multipart/form-data">
					{!! csrf_field() !!}

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