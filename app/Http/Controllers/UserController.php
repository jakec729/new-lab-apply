<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:create.users', ['only' => ['index'] ]);
    }


    public function index() 
    {
    	$users = User::all();
    	// dd($users);
    	return view('users.index', compact('users'));
    }

    public function profile(Request $request, $id)
    {
    	$user = User::findOrFail($id);

        if (! $this->authorize('update', $user) ) {
            return redirect('/');
        }

    	return view('users.show', compact('user'));
    }

    public function changePassword(Request $request, $id)
    {
    	$this->validate($request, [ 
    		'password' => 'required|min:5|max:30',
    		'password_confirm' => 'required|min:5|max:30' 
    	]);

    	$user = User::findOrFail($id);
    	$password = $request->input('password');
    	$password_confirm = $request->input('password_confirm');

    	if ($password !== $password_confirm) {
    		return redirect()->back()->withErrors(["Passwords don't match"]);
    	}

    	if (Hash::check($password, $user->password) ) {
    		return redirect()->back()->withErrors(["Password already in use."]);	
    	}

    	$user->password = Hash::make($password);
    	$user->save();

    	return redirect()->back();
    	
    }
}
