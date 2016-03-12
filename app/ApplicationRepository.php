<?php

namespace App;

use App\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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

    public function submissionsSortedByAverageRating() 
    {
        $apps = DB::table('applications')
            ->select('applications.*')
            ->leftJoin('ratings', 'applications.id', '=', 'ratings.rateable_id')
            ->addSelect(DB::raw('AVG(ratings.rating) as average_rating'))
            ->groupBy('applications.id')
            ->orderBy('average_rating', 'desc')
            ->get();

        $apps = collect($apps);
        $apps = $apps->map(function($item){
            return Application::with('ratings')->find($item->id);
        });

        return $apps;
    }
}
