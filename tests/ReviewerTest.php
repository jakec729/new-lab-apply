<?php

use App\Application;
use Bican\Roles\Models\Role;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ReviewerTest extends TestCase
{
	use DatabaseTransactions;

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

	public function test_can_assign_multiple_reviewers_to_apps()
	{
		$reviewers = [];

		for ($i=0; $i < 5; $i++) { 
			$reviewer = $this->makeReviewer();
			$reviewers[] = $reviewer->id;
		}

		$app = $this->makeApp();
		$app->assignUsersToApp($reviewers);
		$assigned = $app->reviewers;

		$this->assertEquals($assigned->pluck('id')->toArray(), $reviewers);
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

	public function test_user_can_visit_assigned_apps()
	{
		DB::table('applications')->truncate();

		$reviewer = $this->makeReviewer();
		$user = $this->makeUser();
		$app = $this->makeApp();

		$app->assignUserToApp($reviewer);

		$this->actingAs($user)
			 ->visit("applications/{$app->id}")
			 ->see("submission-data");
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

	public function test_reviewers_can_only_see_shortlisted_assigned_apps()
	{
		$a = $this->makeApp();
		$b = $this->makeApp();
		$reviewer = $this->makeReviewer();

		$reviewer->assignAppToUser($a);
		$reviewer->assignAppToUser($b);

		$a->addRating(5, $reviewer);

		$this->actingAs($reviewer)
			 ->visit('applications/shortlisted')
			 ->see("applications/{$a->id}")
			 ->dontSee("applications/{$b->id}");
	}

	public function test_admins_see_assign_reviewers_button()
	{
		$admin = $this->makeAdmin();
		$user = $this->makeUser();
		$reviewer = $this->makeReviewer();
		$app = $this->makeApp();

		$this->actingAs($admin)
			 ->visit("applications/{$app->id}")
			 ->see("Assign Reviewers");

		$this->actingAs($user)
			 ->visit("applications/{$app->id}")
			 ->dontSee("Assign Reviewers");
	}

	public function test_user_sees_all_reviewers()
	{
		DB::table('users')->truncate();
		DB::table('role_user')->truncate();

		$application = $this->makeApp();
		$this->makeEditor();
		$this->makeReviewer();
		$reviewer = $this->makeReviewer();
		$application->assignUserToApp($reviewer);

		$this->assertEquals($application->combinedReviewers()->count(), 2);
	}

	public function test_repository_finds_remianing_reviewers()
	{
	    DB::table('users')->truncate();
	    DB::table('role_user')->truncate();

	    $app = $this->makeApp();
	    $reviewer = $this->makeReviewer();

	    $app->assignUserToApp($reviewer);

	    $this->makeReviewer();
	    $this->makeReviewer();

	    $this->assertEquals(2, $app->remainingReviewers()->count());
	}


	// ERROR: Unreachable field, likely caused by javascript
	
	// public function test_assign_multiple_users_to_app()
	// {
	// 	$admin = $this->makeAdmin();
	// 	$reviewer_a = $this->makeReviewer();
	// 	$reviewer_b = $this->makeReviewer();
	// 	$app = $this->makeApp();

	// 	$this->actingAs($admin)
	// 		 ->visit("applications/{$app->id}")
	// 		 ->check("#input_user_{$reviewer_a->id}")
	// 		 ->check("#input_user_{$reviewer_b->id}")
	// 		 ->press("Confirm")
	// 		 ->see("$reviewer_a->name")
	// 		 ->see("$reviewer_b->name");
	// }
}
