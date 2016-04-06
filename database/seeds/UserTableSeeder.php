<?php

use App\User;
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
        if (! User::where('email', 'jakec729@mac.com')->exists()) {
            factory(User::class)->create([
                'name' => 'Jake Cooper',
                'email' => 'jakec729@mac.com',
                'password' => bcrypt('password')
            ]);
        }

        if (! User::where('email', 'info@newlab.com')->exists()) {
            factory(User::class)->create([
                'name' => 'New Lab Admin',
                'email' => 'info@newlab.com',
                'password' => bcrypt('password')
            ]);
        }

        if (! User::where('email', 'info@newlab.com')->exists()) {
            factory(User::class)->create([
                'name' => 'Test Account',
                'email' => 'test@test.com',
                'password' => bcrypt('password')
            ]);
        }
    }
}
