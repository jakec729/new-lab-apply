<?php

use App\Application;
use App\User;
use Bican\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ApplicationFilterTest extends TestCase
{
	use DatabaseTransactions;

	protected function createAdmin()
	{
		$admin = factory(User::class)->create();
		$admin->attachRole('admin');

		return $admin;
	}

	public function testFiltersNamesAscending()
	{
		$admin = $this->createAdmin();
		$apps = factory(Application::class, 30)->create();
		$sorted = $apps->sortBy('last_name');
		$first = "{$sorted->first()->first_name} {$sorted->first()->last_name}";
		$last = "{$sorted->last()->first_name} {$sorted->last()->last_name}";

		// dd($sorted->pluck('last_name')->all(), $last);

		$this->actingAs($admin)
			 ->visit('/applications')
			 ->check('tableSortBy_name')
			 ->dontSee($last);
	}
}
