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

function comma_to_array($string) {
	return explode(", ", $string);
}

function format_text_submission($string) {
	$string = str_replace('"', '', $string);
	dd($string);
}

function isSelected($val, $match) {
	return ($val == $match) ? "selected" : false;
}

function isChecked($vals, $match) {
	$match = trim(ucwords($match));
	return (in_array($match, $vals)) ? "checked" : false;
}

function mergeCollections($a, $b)
{
	return $a->merge($b)->unique()->reject(function($item){
		return $item == "";
	});
}
