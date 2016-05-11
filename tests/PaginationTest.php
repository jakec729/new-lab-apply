<?php

use App\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PaginationTest extends TestCase
{

	public function test_applications_have_prev_and_next_buttions()
	{
		DB::table('applications')->truncate();

		$admin = $this->makeAdmin();

		$app_1 = factory(Application::class)->create(['submitted_on' => date("U") ]);
		$app_2 = factory(Application::class)->create(['submitted_on' => date("U") ]);
		$app_3 = factory(Application::class)->create(['submitted_on' => date("U") ]);

		$this->actingAs($admin)
			 ->visit("applications/{$app_2->id}")
			 ->see("/applications/{$app_1->id}")
			 ->see("/applications/{$app_3->id}");
	}

	public function test_applications_sometimes_have_prev_and_next_buttions()
	{
		DB::table('applications')->truncate();

		$admin = $this->makeAdmin();

		$app_1 = factory(Application::class)->create(['submitted_on' => date("U") ]);
		$app_2 = factory(Application::class)->create(['submitted_on' => date("U") ]);

		$this->actingAs($admin);

		$this->visit("applications/{$app_2->id}")
			 ->see("/applications/{$app_1->id}")
			 ->dontSee("Next");

		$this->visit("applications/{$app_1->id}")
			 ->see("/applications/{$app_2->id}")
			 ->dontSee("Previous");
	}

}
