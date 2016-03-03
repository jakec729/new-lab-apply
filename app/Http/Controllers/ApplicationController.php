<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

	public function index()
	{
        $total = Application::all()->count();
        $applications = Application::with('ratings')->paginate(10);
        $shortlisted = Application::has('ratings')->get();
        return view('applications.index', compact('applications', 'total', 'shortlisted'));
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
