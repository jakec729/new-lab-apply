<?php

namespace App;

use App\Comment;
use App\Traits\MoreRateable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use willvincent\Rateable\Rating;

class Application extends Model
{
    use Rateable;
	use MoreRateable;

    protected $dates = ['created_at', 'updated_at', 'submitted_on'];
    
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
        'additional_message', 
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

    public function getCompanyAttribute($value)
    {
        return (! empty($value)) ? $value : 'n/a';
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

        if (!empty($value)) {
            $value = str_replace($categories, "", $value);
        } else {
            $value = 'n/a';
        }

        return $value;
    }

    public function getMembershipTypeAttribute($value)
    {
        return (!empty($value)) ? $value : 'n/a';
    }

    public function getWebsiteAttribute($value) 
    {

        if (false === stripos($value, "http://")) {
            $value = "http://" . $value;
        }

        return $value;

    }

    public static function createFromAssociativeArray($array)
    {
        $app = Application::create($array);
        return $app;
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
