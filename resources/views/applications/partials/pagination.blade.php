<form action="" method="GET" class="form-inline">
	<div class="form-group">
		<label for="posts_per_page">Show</label>
		<select name="posts_per_page" id="posts_per_page" class="form-control" onchange='this.form.submit()'>
			<option value="5" {{ ($pagination == 5) ? "selected" : null }}>5</option>
			<option value="10" {{ ($pagination == 10) ? "selected" : null }}>10</option>
			<option value="20" {{ ($pagination == 20) ? "selected" : null }}>20</option>
		</select>
	</div>
</form>
