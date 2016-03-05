<?php 

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rating;

trait MoreRateable 
{
	public function addRating($value)
    {
    	if (! $this->alreadyRated()) {
	    	$rating = new Rating;
	    	$rating->rating = (int) $value;
	    	$rating->user_id = \Auth::id();
	    	$this->ratings()->save($rating);
    	} else {
    		$review = $this->getUserRating();
    		$review->rating = $value;
    		$review->save();
    	}
    }

    public function rating()
    {
        if ($this->hasRatings()) {
            return $this->averageRating;
        } else {
            return "Unrated";
        }
    }

    public function getRatingAttribute()
    {
        return $this->rating();
    }

    public function hasRatings()
    {
        return !! $this->ratings->count();
    }

    public function alreadyRated()
    {
    	return !! $this->ratings->where('user_id', Auth::id(), false)->count();
    }

    public function getUserRating()
    {
    	return $this->ratings->where('user_id', Auth::id(), false)->first();
    }

    public function getUserRatingAttribute()
    {
    	return $this->ratingFromUser();
    }

    public function ratingFromUser()
    {
        if (! $this->alreadyRated()) {
            return false;
        }
        
        return $this->ratings->where('user_id', Auth::id(), false)->first()->rating;
    }
}