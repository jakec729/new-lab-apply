<?php

namespace App\Http\Controllers;

use App\Application;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
		$this->validate($request, [ 
			'comment' => 'required|min:5',
			'application_id' => 'required' 
		]);

		$user = $request->user();
		$body = $request->input('comment');
		$application = Application::findOrFail($request->input('application_id'));

		$comment = new Comment;
		$comment->application_id = $application->id;
		$comment->user_id = $user->id;
		$comment->body = $body;
		$comment->save();

		return redirect()->back();
    }
}
