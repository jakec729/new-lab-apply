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
		$users = User::whereHas('roles', function($query){
			$query->where('slug', 'reviewer');
		})->get();

		return $users;
	}
}
