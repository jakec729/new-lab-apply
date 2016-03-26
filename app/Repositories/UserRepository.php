<?php 
namespace App\Repositories;

use App\User;

class UserRepository
{
	public function reviewers()
	{
		return User::has('roles', '<', 1)->get();
	}
}
