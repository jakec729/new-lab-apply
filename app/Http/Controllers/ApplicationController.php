<?php

namespace App\Http\Controllers;

use App\Application;
use App\CustomPaginator;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\ApplicationRepository;
use App\Session\SessionManager;
use App\User;
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
        $this->middleware('permission:edit.applications', ['only' => ['edit', 'update'] ]);
    }

    protected function formatResultsForTable($applications, $request)
    {
        return ($applications->count() > 0) ? CustomPaginator::create($request, $applications) : false;
    }

    public function search(Request $request, $terms)
    {
        SessionManager::setTableFilter($request);

        $applications = $this->applications->search($terms);
        $applications = $this->formatResultsForTable($applications, $request);

        return view('applications.search', [
            'applications' => $applications,
            'page_title' => "Results for \"{$terms}\""
        ]);

    }

    public function index(Request $request)
    {
        // 1. If it's a search perform the search
        // 2. Get the apps
        // 3. Paginate Apps
        // 4. Redirect to page 1 if requested page isn't available
        // 5. Render view
        
        if ($request->has('search')) {
            return $this->search($request, $request->input('search'));
        }

        SessionManager::setTableFilter($request);
        
        $applications = $this->applications->allSubs();
        $applications = $this->formatResultsForTable($applications, $request);

        if (! $applications) {
            return redirect($request->url());
        }

        return view('applications.index', [
            'applications' => $applications,
            'page_title' => "All Applications"
        ]);
    }

    public function shortlisted(Request $request)
    {
        if ($request->has('search')) {
            return $this->search($request, $request->input('search'));
        }

        SessionManager::setTableFilter($request);

        $applications = $this->applications->shortlistedSubs();
        $applications = $this->formatResultsForTable($applications, $request);

        if (! $applications) {
            return redirect($request->url());
        }

        return view('applications.index', [
            'applications' => $applications,
            'page_title' => 'Shortlisted'
        ]);
    }

    public function edit($application)
    {
        $application = $this->applications->find($application);
        
        return view('applications.edit', ['application' => $application]);
    }

	public function show($id) 
	{
        $applications = $this->applications->allSubs();

        $app_key = $applications->search(function($item, $key) use ($id) {
            return $item->id == $id;
        });

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

    public function update(Request $request, $id)
    {
        $application = Application::find($id);        
        $fields = $request->all();

        unset($fields['_token']);

        if (array_key_exists('new_lab_resources', $fields)) {
            $fields['new_lab_resources'] = comma_separate($fields['new_lab_resources']);
        }

        return ($application->fill($fields)->update()) ? redirect("applications/{$application->id}/edit") : false;
    }

    protected function updatePPG(Request $request)
    {
        $previous = session('posts_per_page');
        $current = ($request->has('posts_per_page')) ? $request->input('posts_per_page') : null;

        if ($current) {
            $request->session()->forget('posts_per_page');
            $request->session()->put('posts_per_page', $current );
    
            if ($current !== $previous) {
                return redirect()->back();
            }
        }
    }

    public function assignReviewersToApps(Request $request)
    {
        $this->validate($request, [ 'users' => 'required' ]);

        if (! $request->user()->can('assign.reviewers')) {
            return redirect()->back()->withErrors(['You are not allowed to assign reviewers']);
        }

        $users = $request->input('users');
        $apps = $request->input('app_ids');
        $apps = (! is_array($apps)) ? explode(',', $apps) : $apps;

        foreach ($apps as $app) {
            $app = Application::find($app);
            $app->assignUsersToApp($users);
        }

        return redirect()->back();
    }

    public function assignReviewers(Request $request, Application $application)
    {
        $this->validate($request, [ 'users' => 'required' ]);

        if (! $request->user()->can('assign.reviewers')) {
            return redirect()->back()->withErrors(['You are not allowed to assign reviewers']);
        }

        $users = collect($request->input('users'))->map(function($user) use ($application) {
            $user = User::find($user);
            $application->assignUserToApp($user);

            return $user;
        });

        return redirect()->back();
    }
}
