<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Bican\Roles\Models\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index () 
    {
    	$roles = Role::all();
    	return view('roles.index', compact('roles'));
    }
}
