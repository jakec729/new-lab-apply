<div class="form">
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