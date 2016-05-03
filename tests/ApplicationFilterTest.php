<?php

use App\Application;
use App\Repositories\ApplicationRepository;
use App\User;
use Bican\Roles\Models\Role;
use Faker\Generator;
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

	public function test_shortlisted_shows_only_3_stars()
	{
		DB::table('applications')->truncate();
		$app = $this->makeApp();
		$app2 = $this->makeApp();
		$editor = $this->makeEditor();

		$app->addRating(5, $editor);
		$app2->addRating(2, $editor);

		$shortlisted = new ApplicationRepository;
		$shortlisted = $shortlisted->shortlisted();

		$this->assertTrue($shortlisted->contains($app));
		$this->assertFalse($shortlisted->contains($app2));
	}

}
