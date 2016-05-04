<form action="{{url('applications/updatePPG')}}" method="POST" class="form-inline">
	{{csrf_field()}}
	<div class="form-group">
		<label for="posts_per_page">Show</label>
		<select name="posts_per_page" id="posts_per_page" class="form-control" onchange='this.form.submit()'>
			<option value="50" {{ (session('posts_per_page') == 50) ? "selected" : null }}>50</option>
			<option value="100" {{ (session('posts_per_page') == 100) ? "selected" : null }}>100</option>
			<option value="200" {{ (session('posts_per_page') == 200) ? "selected" : null }}>200</option>
		</select>
	</div>
</form>
