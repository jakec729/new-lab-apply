<?php 
namespace App\Repositories;

use App\Application;
use App\User;

class UserRepository
{
	public static function allUsers()
	{
		return User::all();
	}

	public static function editors()
	{
		return User::whereHas('roles', function($query){
			$query->where('slug', 'editor');
		})->get();
	}

	public static function reviewers()
	{
		$users = User::all()->filter(function($user){
			return ( $user->can('create.ratings') && ! $user->is('admin') );
		});

		return $users;
	}
}
