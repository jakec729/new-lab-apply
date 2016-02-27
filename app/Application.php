<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use willvincent\Rateable\Rating;

class Application extends Model
{
	use Rateable;

    public function getDisciplinesAttribute($value)
    {
    	return unserialize($value);
    }

    public function addRating($value)
    {
    	if (! $this->alreadyRated()) {
	    	$rating = new Rating;
	    	$rating->rating = (int) $value;
	    	$rating->user_id = \Auth::id();
	    	$this->ratings()->save($rating);
    	}
    }

    public function alreadyRated()
    {
    	return !! $this->ratings->where('user_id', Auth::id(), false);
    }

    public function getUserRatingAttribute()
    {
    	return $this->ratingFromUser();
    }

    public function ratingFromUser()
    {
    	return $this->ratings->where('user_id', Auth::id(), false)->first()->rating;
    }

    public function toArray()
    {
    	$app = parent::toArray();
    	$app['disciplines'] = serialize($app['disciplines']);
    	return $app;
    }
}
