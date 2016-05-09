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
}
