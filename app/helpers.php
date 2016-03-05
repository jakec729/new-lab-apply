<?php 

function worthyOfHalfStar($rating, $test) {
    return ($rating - $test) < 1 && ( ($rating * 10) % ($test * 10) >= 5 );
}
