<?php

namespace App\Repositories;

use App\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationRepository extends Model
{
	public function __construct()
	{
        if(! session('posts_per_page')) session(['posts_per_page' => 20]);
        if(! session('tableSortBy')) session(['tableSortBy' => ['column' => 'submitted_on', 'direction' => 'asc']]);
	}

    public function find($id)
    {
        return Application::find($id);
    }

    public function deleteAll()
    {
        $applications = Application::all();

        foreach ($applications as $application) {
            $application->ratings()->delete();
            $application->delete();
        }
    }

    public function search($terms)
    {        
        return Application::search($terms)->get();
    }

    public function allSubs() 
    {
        $array = $this->allSubmissionsWithAvgRating();
        $apps = $this->appsFromQuery($array);

        $user = request()->user();

        if ($user->hasRole('reviewer')) {
            $apps = $apps->filter(function($app) use ($user){
                return $app->isAssignedToUser($user);
            });
        }

        return $apps;
    }

    public function shortlistedSubs() 
    {
        $array = $this->shortlistedSubmissionsWithAvgRating();
        $apps = $this->appsFromQuery($array);

        return $apps;
    }

    public static function mergeWithColumnValues($column, $array)
    {
        $collection = collect($array);
        return mergeCollections($collection, Application::all()->pluck($column));
    }

    public static function listDisciplines()
    {
        $control = ['A.I.', 'Connected Devices', 'Urban Tech', 'Nano Tech', 'Built Environment', 'Additive Tech', 'Energy', 'Life Sciences'];
        return static::mergeWithColumnValues('discipline', $control);
    }

    public static function listMembershipTypes()
    {
        $control = ["Resident", "Resident Urban Tech", "Urban Tech", "Flex"];
        return static::mergeWithColumnValues('membership_type', $control);
    }

    public static function listFundingStages()
    {
        $control = [];
        return static::mergeWithColumnValues('funding_stage', $control);
    }

    public static function listResources()
    {
        $control = [];
        $values = Application::all()
            ->pluck('new_lab_resources')
            ->map(function($item){
                $values = array_filter(array_map('trim', explode(",", $item)));
                $values = array_map('ucwords', $values);
                return $values;
            })
            ->flatten()
            ->unique();

        return mergeCollections($values, collect($control));
    }

    public function submissions()
    {
        return Application::with('ratings');
    }

    public function count()
    {
    	return $this->submissions()->count();
    }

    public function countShortlisted()
    {
    	return $this->shortlistedSubs()->count();
    }

    protected function allSubmissionsWithAvgRating()
    {

        return DB::table('applications')
                   ->select('applications.*')
                   ->leftJoin('ratings', 'applications.id', '=', 'ratings.rateable_id')
                   ->addSelect(DB::raw('AVG(ratings.rating) as average_rating'))
                   ->groupBy('applications.id');
    }

    protected function shortlistedSubmissionsWithAvgRating()
    {
        return DB::table('applications')
                   ->select('applications.*')
                   ->join('ratings', 'applications.id', '=', 'ratings.rateable_id')
                   ->addSelect(DB::raw('AVG(ratings.rating) as average_rating'))
                   ->groupBy('applications.id')
                   ->havingRaw(DB::raw('AVG(ratings.rating) > 0'));
    }

    protected function appsFromQuery($builder)
    {
        $apps = $this->addFilter($builder)->get();
        return $this->mapArrayToCollection($apps);
    }

    protected function mapArrayToCollection($array)
    {
        $array = collect($array);

        $apps = $array->map(function($item){
            return Application::with('ratings')->find($item->id);
        });

        return $apps;
    }

    protected function addFilter($builder)
    {
        $array = session('tableSortBy');
        $field = ($array['column'] == null) ? 'submitted_on' : $array['column'];
        $direction = $array['direction'];

        // dd($array);

        return $builder->orderBy($field, $direction);
    }
}
