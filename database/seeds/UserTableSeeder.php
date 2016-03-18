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
        factory(App\User::class)->create([
            'name' => 'Jake Cooper',
            'email' => 'jakec729@mac.com',
            'password' => bcrypt('password')
        ]);

        factory(App\User::class)->create([
            'name' => 'New Lab Admin',
            'email' => 'info@newlab.com',
            'password' => bcrypt('password')
        ]);

        factory(App\User::class)->create([
            'name' => 'Test Account',
            'email' => 'test@test.com',
            'password' => bcrypt('password')
        ]);
    }
}
