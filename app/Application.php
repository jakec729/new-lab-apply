<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function getDisciplinesAttribute($value)
    {
    	return unserialize($value);
    }
}
