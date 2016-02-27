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
        $applications = Application::all();
        return view('applications.index', compact('applications'));
    }

	public function show(Application $applications) 
	{
        return view('applications.show', ['application' => $applications]);
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
