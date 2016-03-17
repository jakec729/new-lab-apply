<?php

namespace App\Http\Controllers;

use App\Application;
use App\ApplicationRepository;
use App\CustomPaginator;
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

    protected function setTableFilter(Request $request)
    {
        $active = $request->session()->get('tableSortBy', ['column' => 'average_rating', 'direction' => 'desc']);
        $filter = ($request->has('tableSortBy')) ? $request->input('tableSortBy') : null;

        $direction = '';

        if ($filter == $active['column']) {
            $direction = ($active['direction'] == 'desc') ? 'asc' : 'desc';
        } else {
            $direction = 'asc';
        }

        $request->session()->forget('tableSortBy');
        $request->session()->put('tableSortBy', ['column' => $filter, 'direction' => $direction]);
    }

    protected function formatResultsForTable($applications, $request)
    {
        $this->setTableFilter($request);
        $this->updatePPG($request);

        if ($this->isOffsetPage($request, $applications)) {
            return redirect($request->url());
        }

        return CustomPaginator::paginateCollection($request, $applications);
    }

    public function index(Request $request)
    {
        $applications = $this->applications->allSubs();

        if ($applications->count() > 0) {
            $applications = $this->formatResultsForTable($applications, $request);
        }

        return view('applications.index', compact('applications'));
    }

    protected function isOffsetPage($request, $collection)
    {
        $total = $collection->count();
        $current = $request->input('page', 1);
        $posts_per_page = session('posts_per_page');

        return ($total > $posts_per_page && $current * $posts_per_page > $total);
    }

    public function shortlisted(Request $request)
    {
        $applications = $this->applications->shortlistedSubs();

        if ($applications->count() > 0) {
            $applications = $this->formatResultsForTable($applications, $request);
        }


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

    protected function updatePPG(Request $request)
    {
        $previous = session('posts_per_page');
        $current = ($request->has('posts_per_page')) ? $request->input('posts_per_page') : null;

        if ($current) {
            $request->session()->forget('posts_per_page');
            $request->session()->put('posts_per_page', $current );
    
            if ($current !== $previous) {
                return redirect($request->url());
            }
        }
    }
}
