<?php

use App\User;
use Bican\Roles\Models\Permission;
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

        $adminPermissions = Permission::create([
            'name' => 'Create Ratings',
            'slug' => 'create.ratings',
            'description' => 'Can rate objects'
        ]);

        $adminRole->attachPermission($adminPermissions);

        User::find(1)->attachRole($adminRole);
       	User::find(2)->attachRole($adminRole);
    }
}
