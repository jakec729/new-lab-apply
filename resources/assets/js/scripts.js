$('[data-single-link] > [data-trigger]').each(function(){
	$(this).on('click', function() {
		$url = $(this).parent().attr('data-single-link');
		window.location.href = $url;
	});
});

$('[data-row-select]').each(function() {
	$(this).on('click', function() {
		$(this).find('input[type="checkbox"]').click();
	});
});

$('#assignMultipleReviewersBtn').on('click', function(){
	var $form = $('#multipleReviewersForm');
	var $apps = $('[data-single-link]').find('input[type="checkbox"]:checked');
	var $ids = [];

	$apps.each(function(){
		$ids.push(this.value);
	})

	// $ids = JSON.stringify($ids);

	console.log($ids);

	if ($form.has('[name="app_ids"]').length){
		// console.log("found it");
		$form.find('[name="app_ids"]').attr('value', $ids);
	} else {
		// console.log("appending input");
		var $input = $('<input>').attr({
			name: 'app_ids',
			type: 'hidden',
			value: $ids
		}).appendTo($form);
	}
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