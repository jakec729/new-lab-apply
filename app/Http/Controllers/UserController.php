<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() 
    {
    	$users = User::all();
    	// dd($users);
    	return view('users.index', compact('users'));
    }
}
