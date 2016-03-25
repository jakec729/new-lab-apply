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
        
        if (! $csv) {
            return redirect()->back()->withErrors(['Something Went Wrong']);
        }

        $csv->download();
    }

    public function storeFile($file)
    {
        $name = sha1(time()) . "-" . $file->getClientOriginalName();
        $dest = "tmp/uploads";
        $file->move($dest, $name);

        return "{$dest}/{$name}";
    }

    public function review(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        if ($request->file->getClientOriginalExtension() !== 'csv') {
            return redirect()->back()->withErrors(['File must be CSV']);
        }
        
        $file = $request->file;
        $applications = Csv::formatIntoApplications($request->file);

        if (! $applications) {
            return redirect()->back()->withErrors(['CSV is not formatted properly. CSV must be exported from Ninja Forms.']);
        }

        $duplicates = $applications->filter(function($application){
            return (!! Application::where('email', $application->email)->first());
        });

        $applications = $applications->filter(function($application){
            return (! Application::where('email', $application->email)->first());
        });

        if ($applications->count() > 0) {
            $file = $this->storeFile($file);
        }

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
        $all = Csv::formatIntoApplications($request->input('file'));
        $applications = $all->only($request->input('application_keys'));

        $applications = $applications->map(function($app){
            $app->save();
        });

        return redirect('/applications');
    }

}
