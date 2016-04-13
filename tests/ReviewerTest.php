<?php

use Bican\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ReviewerTest extends TestCase
{
	public function test_reviewer_role_exists()
	{
		$role = Role::where('slug', 'reviewer')->first();
		$this->assertNotEmpty($role);
	}

	public function test_can_assign_reviewers_to_apps()
	{
		$reviewer = $this->makeReviewer();
		$app = $this->makeApp();
		$app->assignUserToApp($reviewer);
		$apps = $reviewer->assignedApps();

		$this->assertEquals($apps->first()->id, $app->id);
	}

	public function test_can_assign_apps_to_reviewers()
	{
		$reviewer = $this->makeReviewer();
		$app = $this->makeApp();
		$reviewer->assignAppToUser($app);
		$apps = $reviewer->assignedApps();

		$this->assertEquals($apps->first()->id, $app->id);
	}

	public function test_can_check_if_user_is_assigned()
	{
		$reviewer = $this->makeReviewer();
		$user = $this->makeUser();
		$app = $this->makeApp();

		$app->assignUserToApp($reviewer);

		$this->assertTrue($app->isAssignedToUser($reviewer));
		$this->assertFalse($app->isAssignedToUser($user));
	}

	public function test_reviewers_can_only_see_assigned_apps()
	{
		$a = $this->makeApp();
		$b = $this->makeApp();
		$reviewer = $this->makeReviewer();
		$reviewer->assignAppToUser($a);

		$this->actingAs($reviewer)
			 ->visit('applications')
			 ->see("applications/{$a->id}")
			 ->dontSee("applications/{$b->id}");
	}
}
