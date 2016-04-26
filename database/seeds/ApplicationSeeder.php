<?php

use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if (App\Application::all()->count() <= 0) {
	        factory(App\Application::class, 60)->create();
    	}
    }
}
