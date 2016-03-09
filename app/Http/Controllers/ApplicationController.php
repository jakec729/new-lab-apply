<?php

namespace App\Http\Controllers;

use App\Application;
use App\ApplicationRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class ApplicationController extends Controller
{
    protected $applications;

    public function __construct(ApplicationRepository $applications)
    {
        $this->applications = $applications;
    }


    public function index(Request $request)
    {
        $applications = $this->applications->paginatedSubmissions();

        return view('applications.index', compact('applications'));
    }

    public function shortlisted()
    {
        $applications = $this->applications->getShortlisted();
        // dd($applications);
        return view('applications.shortlisted', compact('applications'));
    }

	public function show($applications) 
	{
        $applications = Application::with('ratings', 'comments')->find($applications);
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

    public function addComment(Request $request, Application $applications)
    {
        $this->validate($request, [ 
            'comment' => 'required|min:5',
            'application_id' => 'required' 
        ]);

        $body = $request->input('comment');
        $applications->addComment($body, $request->user()->id);

        return redirect()->back();

    }

    public function updatePPG(Request $request)
    {
        $request->session()->forget('posts_per_page');
        $request->session()->put('posts_per_page', $request->input('posts_per_page') );
        return redirect()->back();
    }
}
