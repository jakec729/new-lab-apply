<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return factory(App\User::class)->create([
        	'name' => 'Jake Cooper',
        	'email' => 'jakec729@mac.com',
        	'password' => bcrypt('password')
        ]);
    }
}
