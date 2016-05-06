<?php

use App\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ApplicationTableTest extends TestCase
{
	use DatabaseTransactions;

	public function test_no_results_when_zero_apps()
	{
		DB::table('applications')->truncate();
		$admin = $this->makeAdmin();

		$this->actingAs($admin)
			 ->visit('/')
			 ->see('No Applications');
	}
}
