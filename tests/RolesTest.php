<?php

use App\Application;
use App\Repositories\UserRepository;
use App\User;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RolesTest extends TestCase
{
	use DatabaseTransactions;

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
		$admin = $this->makeAdmin();		
		$reader = $this->makeReader();
		$user = $this->makeUser();	
		$application = $this->makeApp();

		$this->actingAs($editor)
			 ->visit("/applications/{$application->id}")
			 ->see("userRatingForm");

		$this->actingAs($admin)
			 ->visit("/applications/{$application->id}")
			 ->see("userRatingForm");

		$this->actingAs($reader)
			 ->visit("/applications/{$application->id}")
			 ->dontSee("userRatingForm");

		$this->actingAs($user)
			 ->visit("/applications/{$application->id}")
			 ->dontSee("userRatingForm");
	}

	public function testSeeReviewerRatings()
	{
		$admin = $this->makeAdmin();
		$editor = $this->makeEditor();
		$user = $this->makeUser();

		// MAKE TEST TO HIDE ADMIN RATINGS
		$application = factory(Application::class)->create();
		$application->addRating(5, $editor->id);

		$this->actingAs($admin)
			 ->visit("/applications/{$application->id}")
			 ->dontSee("label-star selected");

		$this->actingAs($editor)
			 ->visit("/applications/{$application->id}")
			 ->see("label-star selected");

		$this->actingAs($user)
			 ->visit("/applications/{$application->id}")
			 ->see('data-user-rating="5"');
	}

	public function test_users_can_only_have_one_role()
	{
		$admin = $this->makeAdmin();

		$this->actingAs($admin)
			 ->visit("users/{$admin->id}")
			 ->select("reader", 'user_roles')
			 ->press("Update Role");

		$this->assertEquals($admin->roles->count(), 1);

		$user = $this->makeUser();

		$this->actingAs($user)
			 ->visit("users/{$user->id}")
			 ->select("reader", 'user_roles')
			 ->press("Update Role");

		$this->assertEquals($user->roles->count(), 1);
	}

}
