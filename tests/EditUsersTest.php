<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditUsersTest extends TestCase
{
	use DatabaseTransactions;

	public function test_editors_can_edit_users()
	{
		$editor = $this->makeEditor();
		$user = $this->makeUser();

		$this->actingAs($editor)
			 ->visit("users/{$user->id}")
			 ->see($user->name);
	}

	public function test_admins_can_edit_users()
	{
		$admin = $this->makeAdmin();
		$user = $this->makeUser();

		$this->actingAs($admin)
			 ->visit("users/{$user->id}")
			 ->see($user->name);
	}

	public function test_user_can_edit_themsleves()
	{
		$user = $this->makeUser();

		$this->actingAs($user)
			 ->visit("users/{$user->id}")
			 ->see($user->name);
	}

	public function test_editor_can_update_user_roles()
	{
		$editor = $this->makeEditor();
		$user = $this->makeUser();

		$this->visit("users/{$user->id}")
			 ->select("reviewer", "roles")
			 ->press("Update Role");

		$this->assertTrue($user->fresh()->hasRole('reviewer'));
	}

	public function test_editors_cant_make_admins()
	{
		$editor = $this->makeEditor();
		$user = $this->makeUser();

		$this->visit("users/{$user->id}")
			 ->dontSee("admin");
	}
}
