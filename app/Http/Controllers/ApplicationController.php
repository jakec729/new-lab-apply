<?php

namespace App\Http\Controllers;

use App\Application;
use App\ApplicationRepository;
use App\CustomPaginator;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\URL;

class ApplicationController extends Controller
{
    protected $applications;


    public function __construct(ApplicationRepository $applications)
    {
        $this->applications = $applications;
        $this->middleware('admin', ['only' => ['delteAll']]);
    }

    protected function setTableFilter(Request $request)
    {
        $active = $request->session()->get('tableSortBy', ['column' => 'submitted_on', 'direction' => 'asc']);
        $filter = ($request->has('tableSortBy')) ? $request->input('tableSortBy') : null;

        $direction = '';

        if ($filter == $active['column']) {
            $direction = ($active['direction'] == 'asc') ? 'desc' : 'asc';
        } else {
            $direction = 'desc';
        }

        $request->session()->forget('tableSortBy');
        $request->session()->put('tableSortBy', ['column' => $filter, 'direction' => $direction]);
    }

    protected function formatResultsForTable($applications, $request)
    {
        if ($this->isOffsetPage($request, $applications)) {
            return redirect($request->url());
        }

        return CustomPaginator::paginateCollection($request, $applications);
    }

    public function index(Request $request)
    {
        $this->setTableFilter($request);
        $this->updatePPG($request);
        
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

        return ($total > $posts_per_page && ($current - 1) * $posts_per_page > $total);
    }

    public function shortlisted(Request $request)
    {
        $this->setTableFilter($request);
        $this->updatePPG($request);

        $applications = $this->applications->shortlistedSubs();

        if ($applications->count() > 0) {
            $applications = $this->formatResultsForTable($applications, $request);
        }


        return view('applications.shortlisted', compact('applications'));
    }

	public function show($id) 
	{
        $applications = $this->applications->allSubs();

        $app_key = $applications->search(function($item, $key) use ($id) {
            return $item->id == $id;
        });

        if ($app_key == false) {
            return redirect('/applications');
        }

        $application = (isset($app_key)) ? $applications[$app_key] : null;
        $next = ($applications[$app_key + 1]) ? $applications[$app_key + 1]->id : null;
        $previous = ($app_key - 1 >= 0 && $applications[$app_key - 1]) ? $applications[$app_key - 1]->id : null;

        return view('applications.show', [
            'application' => $application,
            'next' => $next,
            'previous' => $previous,
        ]);
    }

    public function rate(Request $request, Application $application)
    {
    	$this->validate($request, [ 'rating' => 'required' ]);

        $rating = $request->input('rating');

        if ($rating == 'remove') {
            $application->removeRating();
        } else {
        	$application->addRating($request->input('rating'));
        }

        $previous = URL::previous();

    	return redirect($previous . "#app__ratings");
    }

    public function addComment(Request $request, Application $applications)
    {
        $this->validate($request, [ 
            'comment' => 'required|min:5',
            'application_id' => 'required' 
        ]);

        $body = $request->input('comment');
        $applications->addComment($body, $request->user()->id);

        $previous = URL::previous();

        return redirect($previous . "#app__ratings");
    }

    public function deleteAll()
    {
        $this->applications->deleteAll();

        return redirect('/applications');
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
