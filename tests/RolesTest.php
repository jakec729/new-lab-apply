<?php

use App\Application;
use App\User;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RolesTest extends TestCase
{
	use DatabaseTransactions;

	protected function makeReader()
	{
		$user = factory(User::class)->create();
		$role = Role::where('slug', 'reader')->first();
		$user->attachRole($role);
		$user = $user->fresh();

		return $user;
	}

	protected function makeEditor()
	{
		$user = factory(User::class)->create();
		$role = Role::where('slug', 'editor')->first();
		$user->attachRole($role);
		$user = $user->fresh();

		return $user;
	}

	protected function makeAdmin()
	{
		$user = factory(User::class)->create();
		$role = Role::where('slug', 'admin')->first();
		$user->attachRole($role);
		$user = $user->fresh();

		return $user;
	}

	public function testReaderCantRateApplications()
	{
		$reader = $this->makeReader();
		$admin = $this->makeAdmin();
		$application = factory(Application::class)->create();

		$this->actingAs($reader)
			 ->visit("/applications/{$application->id}")
			 ->dontSee("userRatingForm");

		$this->actingAs($admin)
			 ->visit("/applications/{$application->id}")
			 ->see("userRatingForm");
	}

	public function testAdminCanRateApplications()
	{
		$admin = $this->makeAdmin();
		$application = factory(Application::class)->create();
		$permission = Permission::where('slug', 'create.ratings')->first();

		$this->actingAs($admin)
			 ->visit("/applications/{$application->id}")
			 ->see("userRatingForm");
	}

	public function testEditorCanCreateUsers()
	{
		$editor = $this->makeEditor();

		$this->actingAs($editor)
			 ->visit('/users')
			 ->see('<h1 class="submission__heading">All Users</h1>');
	}

	public function testEditorCanRateApplications()
	{
		$editor = $this->makeEditor();		
		$application = factory(Application::class)->create();

		$this->actingAs($editor)
			 ->visit("/applications/{$application->id}")
			 ->see("userRatingForm");

		// $this->actingAs($admin)
		// 	 ->visit("/applications/{$application->id}")
		// 	 ->see("userRatingForm");

		// $this->actingAs($reader)
		// 	 ->visit("/applications/{$application->id}")
		// 	 ->dontSee("userRatingForm");
	}

}
