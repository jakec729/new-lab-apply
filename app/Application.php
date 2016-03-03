<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use willvincent\Rateable\Rating;

class Application extends Model
{
	use Rateable;

    // protected $dateFormat = 'U';

    protected $fillable = [
        'name', 
        'email', 
        'company',
        'website', 
        'desks', 
        'disciplines', 
        'membership_type', 
        'text_pitch', 
        'text_tech', 
        'text_team', 
        'text_strategy', 
        'funding_stage', 
        'new_lab_resources', 
        'text_community' 
    ];

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

    public function toArray()
    {
    	$app = parent::toArray();
    	$app['disciplines'] = serialize($app['disciplines']);
    	return $app;
    }
}
