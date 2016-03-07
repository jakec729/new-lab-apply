<form action="/applications/updatePPG" method="POST" class="form-inline">
	{{csrf_field()}}
	<div class="form-group">
		<label for="posts_per_page">Show</label>
		<select name="posts_per_page" id="posts_per_page" class="form-control" onchange='this.form.submit()'>
			<option value="5" {{ (session('posts_per_page') == 5) ? "selected" : null }}>5</option>
			<option value="10" {{ (session('posts_per_page') == 10) ? "selected" : null }}>10</option>
			<option value="20" {{ (session('posts_per_page') == 20) ? "selected" : null }}>20</option>
		</select>
	</div>
</form>
