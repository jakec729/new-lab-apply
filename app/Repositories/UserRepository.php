<?php 
namespace App\Repositories;

use App\User;

class UserRepository
{
	public function allUsers()
	{
		return User::all();
	}

	public function reviewers()
	{
		return $this->allUsers()->filter(function($user){
			return ($user->can('create.ratings') && ! $user->hasRole('admin'));
		});
	}
}
