$rows = $('[data-single-link');

$rows.each(function(){
	$(this).on('click', function() {
		$url = $(this).attr('data-single-link');
		window.location.href = $url;
	});
});