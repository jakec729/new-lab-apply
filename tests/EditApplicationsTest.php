<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditApplicationsTest extends TestCase
{
	use DatabaseTransactions;

	public function test_only_some_can_edit()
	{
		$admin = $this->makeAdmin();
		$editor = $this->makeEditor();
		$user = $this->makeUser();
		$app = $this->makeApp();

		$this->actingAs($admin)
			 ->visit("applications/{$app->id}/edit")
			 ->see("Save Changes");

		$this->actingAs($editor)
			 ->visit("applications/{$app->id}/edit")
			 ->see("Save Changes");
	}

	public function test_can_get_to_edit_page()
	{
		$admin = $this->makeAdmin();
		$app = $this->makeApp();

		$this->actingAs($admin)
			 ->visit("applications/{$app->id}/edit")
			 ->see($app->company)
			 ->see("Save Changes");
	}

	public function test_changes_are_saved()
	{
		$admin = $this->makeAdmin();
		$app = $this->makeApp();

		$this->actingAs($admin)
			 ->visit("applications/{$app->id}/edit")
			 ->type('Jane', 'first_name')
			 ->type('Doe', 'last_name')
			 ->type('john.doe@test.com', 'email')
			 ->type('Acme Co.', 'company')
			 ->type('www.example.com', 'website')
			 ->type('jkfasdf', 'link_1')
			 ->type('jkgfasdf', 'link_2')
			 ->select('2-4', 'desks')
			 ->select('Resident', 'membership_type')
			 ->press("Save Changes")
			 ->see('Jane')
			 ->see('Doe')
			 ->see('john.doe@test.com')
			 ->see('Acme Co.')
			 ->see('www.example.com')
			 ->see('jkfasdf')
			 ->see('jkgfasdf')
			 ->see('2-4')
			 ->see('Resident');
	}
}
