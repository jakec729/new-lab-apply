<?php 
namespace App\Repositories;

use App\User;

class UserRepository
{
	public static function allUsers()
	{
		return User::all();
	}

	public static function reviewers()
	{
		return User::with('roles')->get()->filter(function($user){
			return ($user->can('create.ratings') && ! $user->hasRole('admin'));
		});
	}
}
