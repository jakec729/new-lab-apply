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

    public function formatApps($applications, $request)
    {
        return ($applications->count() > 0) ? CustomPaginator::create($request, $applications) : $applications;
    }

    public function search(Request $request, $terms)
    {
        SessionManager::setTableFilter($request);
        $applications = $this->applications->search($terms);
        $applications = $this->formatApps($applications, $request);

        if (! $applications) {
            return redirect($request->url() . "?search={$terms}");
        }

        return view('applications.search', [
            'applications' => $applications,
            'page_title' => "Results for \"{$terms}\""
        ]);
    }

    public function checkForSearch(Request $request)
    {
        if ($request->has('search')) {
            return $this->search($request, $request->input('search'));
        }
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            return $this->search($request, $request->input('search'));
        }

        SessionManager::setTableFilter($request);
        $applications = $this->applications->allSubs();
        $applications = $this->formatApps($applications, $request);

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
        $applications = $this->formatApps($applications, $request);

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

        $app_key = $applications->search(function($app) use ($id) {
            return $app->id == $id;
        });

        if ($app_key === false) {
            return redirect('/');
        }

        $application = $applications[$app_key];
        $next = (isset($applications[$app_key + 1])) ? $applications[$app_key + 1] : null;
        $prev = (isset($applications[$app_key - 1])) ? $applications[$app_key - 1] : null;

        $application = $applications[$app_key];
        $next = (isset($applications[$app_key + 1])) ? $applications[$app_key + 1]->id : null;
        $prev = (isset($applications[$app_key - 1])) ? $applications[$app_key - 1]->id : null;

        return view('applications.show', [
            'application' => $application,
            'next' => $next,
            'previous' => $prev,
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
