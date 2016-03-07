<?php

namespace App;

use App\Application;
use Illuminate\Database\Eloquent\Model;

class ApplicationRepository extends Model
{
    public function count()
    {
    	return Application::all()->count();
    }

    public function getShortlisted()
    {
    	return Application::whereHas('ratings', function ($query) {
    	    $query->where('rating', '>', 0);
    	})->get();
    }

    public function countShortlisted()
    {
    	return $this->getShortlisted()->count();
    }
}
