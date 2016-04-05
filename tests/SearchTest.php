<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{

	protected function makeAdmin()
	{
	    $user = factory(App\User::class)->create();
	    $user->attachRole('admin');

	    return $user;
	}

	public function testSearchPage()
	{
		$admin = $this->makeAdmin();

		$this->actingAs($admin)
			 ->visit('/applications?search=Test')
			 ->see("Results for \"Test\"");
	}
}
