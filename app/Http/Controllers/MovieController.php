<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Movie;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all();

        return view('movies.index', compact('movies'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::with('comments.user')->findOrFail($id);

        return view('movies.show', compact('movie'));
    }

    public function addComment(Request $request, $movie_id)
    {
        $comment = new Comment($request->all());
        $comment->user_id = Auth::user()->id;
        $comment->movie_id = (int) $movie_id;
        $comment->save();

        return redirect()->back();
    }


    public function indexForm(Request $request)
    {
        $this->validate($request, [ 'movie_ids' => 'required' ]);

        if ($request->has('action_assign')) {
            return redirect('/movies/assign')->with('movie_ids', $request->input('movie_ids'));
        }
        
        if ($request->has('action_delete')) {
            return $this->destroyMany($request->input('movie_ids'));
        }

        dd($request->all());
    }

    public function destroyMany($ids)
    {
        Movie::destroy($ids);
        return redirect('/movies');
    }

    public function assignMoviesToUsers(Request $request)
    {
        if (! $request->session()->has('movie_ids')) {
            return redirect()->back();
        }

        $movies = Movie::findOrFail($request->session()->get('movie_ids'));
        $users = User::all();

        return view('movies.assign', compact('movies', 'users'));
    }

}
