<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Csv;
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

    public function review(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $applications = Csv::formatIntoApplications($request->file);

        dd($applications);

        // $movies = Movie::formatMoviesFromFile($request->file);
        $file = $request->file;

        return view('movies.review', compact('movies', 'file'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movies = collect(unserialize($request->input('file')))->only($request->input('movie_keys'));
        $movies->map(function($movie){
            Movie::create($movie);
        });

        return redirect('/movies');
    }

}
