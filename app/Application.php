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
        'submitted_on',
        'first_name', 
        'last_name', 
        'email', 
        'company',
        'website', 
        'link_1', 
        'link_2', 
        'desks', 
        'discipline', 
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

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getDesksAttribute($value)
    {
        $categories = [
            'Solo: ',
            'Small: ',
            'person',
            'Medium: ',
            'Micro: ',
            'Large: '
        ];
        return str_replace($categories, "", $value);
    }

    public function resources()
    {
        return comma_to_array($this->new_lab_resources);
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
