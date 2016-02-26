<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Movie;
use Illuminate\Http\Request;

class FileController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    public function review(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $movies = Movie::formatMoviesFromFile($request->file);
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
