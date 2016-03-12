<?php 

function worthyOfHalfStar($rating, $test) {
    return ($rating - $test) < 1 && ( ($rating * 10) % ($test * 10) >= 5 );
}

function set_active($uri) {
	return Request::is($uri) ? 'active' : '';
}

function comma_separate($array) {
	return implode(", ", $array);
}

function comma_to_array($array) {
	return explode(", ", $array);
}

function format_text_submission($string) {
	$string = str_replace('"', '', $string);
	dd($string);
}
