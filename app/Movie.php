<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['name', 'year', 'watched'];
}
