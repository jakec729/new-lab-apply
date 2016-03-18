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

    public static function createFromArray($array)
    {
        $app = new Application();

        // dd(Carbon::createFromFormat('d/m/Y', $array[1]));

        $app->submitted_on          = Carbon::createFromFormat('d/m/Y', $array[1]);
        $app->first_name            = ucwords($array[2]);
        $app->last_name             = ucwords($array[3]);
        $app->email                 = $array[4];
        $app->company               = ucwords($array[5]);
        $app->website               = $array[6];
        $app->link_1                = ($array[7] == "Add another related link") ? "" : $array[7];
        $app->link_2                = ($array[8] == "Add another related link") ? "" : $array[8];
        $app->desks                 = $array[9];
        $app->discipline            = $array[10];
        $app->membership_type       = $array[11];
        $app->text_pitch            = $array[12];
        $app->text_tech             = $array[13];
        $app->text_team             = $array[14];
        $app->text_strategy         = $array[15];
        $app->funding_stage         = $array[16];
        $app->new_lab_resources     = str_replace(",", ", ", $array[17]);
        $app->text_community        = $array[18];

        return $app;
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
