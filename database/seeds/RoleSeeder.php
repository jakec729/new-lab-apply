<?php

use App\User;
use Bican\Roles\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrators have access to everything'
        ]);

       	User::find(1)->attachRole($adminRole);
    }
}
