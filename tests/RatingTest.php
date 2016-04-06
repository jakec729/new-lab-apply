<?php

use App\User;
use Bican\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class RatingTest extends TestCase
{

	protected function makeAdmin()
	{
		$user = factory(User::class)->create();
		$role = Role::where('slug', 'admin')->first();
		$user->attachRole($role);
		$user = $user->fresh();

		return $user;
	}

	public function testRatingByForm()
	{
		$admin = $this->makeAdmin();
		$app = factory(App\Application::class)->create();

		$this->actingAs($admin);
		$app->addRating(5);
		
		$app = $app->fresh();

		$this->assertTrue($app->hasRatingByUser($admin->id));
	}
}
