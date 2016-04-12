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

		$last = factory(Application::class)->create([
			'first_name' => 'Zzzzzz', 
			'last_name' => 'Zzzzzzz'
		]);

		$first = factory(Application::class)->create([
			'first_name' => 'Aaaaa', 
			'last_name' => 'Aaaaaa'
		]);

		$first = "{$first->first_name} {$first->last_name}";
		$last = "{$last->first_name} {$last->last_name}";

		$this->actingAs($admin)
			 ->visit('/applications?tableSortBy=last_name')
			 ->see($last);

		$this->actingAs($admin)
			 ->visit('/applications?tableSortBy=last_name')
			 ->see($first);
	}

	// public function testPostsPerPage()
	// {
	// 	DB::table('applications')->truncate();
	// 	$apps = factory(Application::class, 30)->create();
	// 	$admin = $this->createAdmin();

	// 	$this->actingAs($admin)
	// 		 ->visit('/applications')
	// 		 ->see('?posts_per_page=20&page=2');

		// $this->actingAs($admin)
		// 	 ->visit('/applications?posts_per_page=20')
		// 	 ->dontSee('?posts_per_page=20&page=3');

		// $this->actingAs($admin)
		// 	 ->visit('/applications?posts_per_page=10')
		// 	 ->see('?posts_per_page=10&page=3');

		// $this->actingAs($admin)
		// 	 ->visit('/applications?posts_per_page=10')
		// 	 ->dontSee('?posts_per_page=10&page=4');

		// $this->actingAs($admin)
		// 	 ->visit('/applications?posts_per_page=5')
		// 	 ->see('?posts_per_page=5&page=6');

		// $this->actingAs($admin)
		// 	 ->visit('/applications?posts_per_page=5')
		// 	 ->dontSee('?posts_per_page=5&page=7');
	// }
}
