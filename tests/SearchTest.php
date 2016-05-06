<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
	use DatabaseTransactions;

	public function testFormSubmitsToCorrectUrl()
	{
		$admin = $this->makeAdmin();

		$this->actingAs($admin)
			 ->visit('/applications')
			 ->type('Test', 'search')
			 ->press('Search')
			 ->seePageIs('/applications?search=Test');
	}

	public function testSearchPage()
	{
		$admin = $this->makeAdmin();

		$this->actingAs($admin)
			 ->visit('/applications?search=Test')
			 ->see("Results for \"Test\"");
	}

	public function test_changing_posts_per_page_keeps_search_results()
	{
		$admin = $this->makeAdmin();
		$name = "Jake";
		$application = factory(App\Application::class)->create(['first_name' => $name]);

		$this->actingAs($admin)
			 ->visit('/applications')
			 ->type($name, 'search')
			 ->press('Search')
			 ->see("applications/{$application->id}")
			 ->visit("applications/?search=$name&posts_per_page=10")
			 ->see($name);
	}

	public function testSearchShowsResultsInName()
	{
		$admin = $this->makeAdmin();
		$name = "Jake";
		$application = factory(App\Application::class)->create(['first_name' => $name]);

		$this->actingAs($admin)
			 ->visit('/applications')
			 ->type($name, 'search')
			 ->press('Search')
			 ->see("applications/{$application->id}");
	}

	public function testSearchShowsResultsInEmail()
	{
		$admin = $this->makeAdmin();
		$email = "test@test.com";
		$application = factory(App\Application::class)->create(['email' => $email]);

		$this->actingAs($admin)
			 ->visit('/applications')
			 ->type($email, 'search')
			 ->press('Search')
			 ->see("applications/{$application->id}");
	}

	public function testSearchShowsResultsForCompany()
	{
		$admin = $this->makeAdmin();
		$company = "Acme Co.";
		$application = factory(App\Application::class)->create(['company' => $company]);

		$this->actingAs($admin)
			 ->visit('/applications')
			 ->type($company, 'search')
			 ->press('Search')
			 ->see("applications/{$application->id}");
	}
}
