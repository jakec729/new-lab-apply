<?php

namespace App;

use App\User;
use App\Application;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'application_id'];

    public function application()
    {
    	return $this->belongsTo(Application::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

}
