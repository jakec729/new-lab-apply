<?php

use Bican\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RolesTest extends TestCase
{
	use DatabaseTransactions;

	public function testAdminsSeeEverything()
	{
		if (! Role::where('slug', 'admin')->first()) {
			Role::create([
			    'name' => 'Admin',
			    'slug' => 'admin'
			]);
		}

		$adminRole = Role::where('slug', 'admin')->first();

		$admin = factory(App\User::class)->create();
		$movies = factory(App\Movie::class, 10)->create();

		$admin->attachRole($adminRole);

		dd($admin->roles);

		$this->actingAs($admin)
			 ->visit('/movies')
			 ->dontSee('No movies to show.');
	}

	public function testGuestsSeeNothing()
	{
		$guest = factory(App\User::class)->create();
		$movies = factory(App\Movie::class, 10)->create();

		$this->actingAs($guest)
			 ->visit('/movies')
			 ->dontSee('No movies to show.');
	}
}
