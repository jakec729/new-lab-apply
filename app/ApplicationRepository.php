<?php

namespace App;

use App\Application;
use Illuminate\Database\Eloquent\Model;

class ApplicationRepository extends Model
{
	public function __construct()
	{
		if(! session('posts_per_page')) session(['posts_per_page' => 5]);
	}

    public function count()
    {
    	return $this->submissions()->count();
    }

    public function getAllShortlisted()
    {
        $applications = Application::with('ratings')
                        ->whereHas('ratings', function ($query) {
                            $query->where('rating', '>', 0);
                        })->get();
        return $applications;
    }

    public function getShortlisted()
    {
    	return Application::with('ratings')
    			->whereHas('ratings', function ($query) {
		    	    $query->where('rating', '>', 0);
		    	})
                ->orderBy('rating', 'desc')
                ->orderBy('created_at', 'desc')
		    	->paginate(session('posts_per_page'));
    }

    public function countShortlisted()
    {
    	return $this->getShortlisted()->count();
    }

    public function submissions()
    {
    	return Application::with('ratings');
    }

    public function paginatedSubmissions()
    {
        $apps = $this->submissions()
                     // ->orderBy('average_rating', 'desc')
                     ->orderBy('created_at', 'desc')
                     ->paginate(session('posts_per_page'));
                     
        return $apps;
    }
}
