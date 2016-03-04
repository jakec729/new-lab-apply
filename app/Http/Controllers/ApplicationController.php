<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    protected function setPagination(Request $request)
    {
        $pagination = 10;
        $posts_per_page = ($request->has('posts_per_page')) ? $request->input('posts_per_page') : null;

        if ($posts_per_page) {
            $pagination = $request->input('posts_per_page');
        }

        return $pagination;
    }


    public function index(Request $request)
    {
        $pagination = $this->setPagination($request);
        $apps_builder = Application::with('ratings');
        $total = $apps_builder->get()->count();
        $applications = $apps_builder->paginate($pagination);
        $shortlisted = $apps_builder->has('ratings')->get();

        return view('applications.index', compact('applications', 'total', 'shortlisted', 'pagination'));
    }

	public function show(Application $applications) 
	{
        $previous = Application::where('id', '<', $applications->id)->max('id');
        $next = Application::where('id', '>', $applications->id)->min('id');

        return view('applications.show', [
            'application' => $applications,
            'next' => $next,
            'previous' => $previous,
        ]);
    }

    public function rate(Request $request, Application $application)
    {
    	$this->validate($request, [ 'rating' => 'required|min:1|max:5' ]);
    	$application->addRating($request->input('rating'));

    	return redirect()->back();
    }

    public function downloadCSV()
    {
    	$csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

    	$csv->insertOne(\Schema::getColumnListing('applications'));

    	$applications = Application::all();

    	$applications->each(function($application) use($csv) {
    	    $csv->insertOne($application->toArray());
    	});

    	$date = sha1(date('u'));

    	$csv->output("{$date}-applications.csv");
    }
}
