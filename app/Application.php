<?php

namespace App;

use App\Comment;
use App\Repositories\UserRepository;
use App\Traits\MoreRateable;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Nicolaslopezj\Searchable\SearchableTrait;
use willvincent\Rateable\Rateable;
use willvincent\Rateable\Rating;

class Application extends Model
{
    use Rateable;
	use MoreRateable;
    use SearchableTrait;

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

    protected $searchable = [
           'columns' => [
               'applications.first_name' => 10,
               'applications.last_name' => 10,
               'applications.company' => 10,
               'applications.email' => 5,
               'applications.website' => 5,
           ]
       ];

    protected $appends = ['rating'];
    protected $hidden = ['ratings'];

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getCompanyAttribute($value)
    {
        return (! empty($value)) ? $value : '(Not submitted)';
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

    public function reviewers()
    {
        return $this->belongsToMany(User::class);
    }

    public function combinedReviewers()
    {
        return UserRepository::editors()->merge($this->reviewers);
    }

    public function assignUserToApp(User $user)
    {
        $this->reviewers()->save($user);
    }

    public function isAssignedToUser(User $user)
    {
        return $this->reviewers->contains($user);
    }
}
