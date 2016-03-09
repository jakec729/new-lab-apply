<?php

namespace App;

use App\Comment;
use App\Traits\MoreRateable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use willvincent\Rateable\Rating;

class Application extends Model
{
    use Rateable;
	use MoreRateable;

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

    protected $appends = [ 'rating' ];
    protected $hidden = [ 'ratings' ];

    public function getDisciplinesAttribute($value)
    {
    	return unserialize($value);
    }

    public function toArray()
    {
    	$app = parent::toArray();
    	$app['disciplines'] = serialize($app['disciplines']);
    	return $app;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($body, $user_id)
    {
        $comment = new Comment;
        $comment->application_id = $this->id;
        $comment->user_id = $user_id;
        $comment->body = $body;
        $comment->save();
    }
}
