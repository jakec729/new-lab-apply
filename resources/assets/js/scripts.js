$rows = $('[data-single-link');

$rows.each(function(){
	$(this).on('click', function() {
		$url = $(this).attr('data-single-link');
		window.location.href = $url;
	});
});

$('[data-row-select]').each(function() {
	$(this).on('click', function() {
		$(this).find('input[type="checkbox"]').click();
	});
});

$confirm = $('[data-confirm]');

$confirm.each(function(){
	$(this).on('click', function(e) {
		e.preventDefault();
		$url = $(this).attr('href');
		if (window.confirm("Are you sure?")) {
			window.location.href = $url;
		}
	});
});