<?php

namespace App\Http\Controllers;

use App\Application;
use App\Csv;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class FileController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('files.import');
    }

    public function downloadCSV(Request $request)
    {
        if (! $request->has('applications_filter')) {
            return redirect()->back()->withErrors(['Need to select a filter']);
        }

        $csv = Csv::createApplicationCSV($request->input('applications_filter'));
        $csv->download();
    }

    public function review(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $file = $request->file;
        $applications = Csv::formatIntoApplications($request->file);

        $duplicates = $applications->filter(function($application){
            return (!! Application::where('email', $application->email)->first());
        });

        $applications = $applications->filter(function($application){
            return (! Application::where('email', $application->email)->first());
        });

        return view('applications.review', compact('applications', 'duplicates', 'file'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = collect( unserialize( $request->input('file') ) );
        $applications = $all->only($request->input('application_keys'));

        $applications = $applications->map(function($movie){
            $app = Application::createFromAssociativeArray($movie);
            return $app;
        });

        return redirect('/applications');
    }

}
