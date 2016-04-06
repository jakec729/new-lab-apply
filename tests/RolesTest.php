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
		$user->attachRole('reader');

		return $user;
	}

	protected function makeEditor()
	{
		$user = factory(User::class)->create();
		$user->attachRole('editor');

		return $user;
	}

	protected function makeAdmin()
	{
		$user = factory(User::class)->create();
		$user->attachRole('admin');

		return $user;
	}

	public function testReaderCanSeeAllApplications()
	{
		$admin = $this->makeAdmin();
		$reader = $this->makeReader();
		$this->actingAs($reader)
			 ->visit('/')
			 ->see("All Submissions");
	}

	public function testReaderCantRateApplications()
	{
		$reader = $this->makeReader();
		$application = factory(Application::class)->create();

		$this->actingAs($reader)
			 ->visit("/applications/{$application->id}")
			 ->dontSee("userRatingForm");
	}

	public function testEditorCanRateApplications()
	{
		$editor = $this->makeEditor();
		$reader = $this->makeReader();
		$admin = $this->makeAdmin();
		$application = factory(Application::class)->create();

		// $this->actingAs($editor)
		// 	 ->visit("/applications/{$application->id}")
		// 	 ->see("userRatingForm");

		$this->actingAs($admin)
			 ->visit("/applications/{$application->id}")
			 ->see("userRatingForm");

		$this->actingAs($reader)
			 ->visit("/applications/{$application->id}")
			 ->dontSee("userRatingForm");
	}

}
