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

        $readerRole = Role::create([
            'name' => 'Reader',
            'slug' => 'reader',
            'description' => 'Readers can read all applications, but cannot rate or comment on them'
        ]);

        $createRatings = Permission::create([
            'name' => 'Create Ratings',
            'slug' => 'create.ratings',
            'description' => 'Can rate objects'
        ]);

        $createUsers = Permission::create([
            'name' => 'Create Users',
            'slug' => 'create.users',
            'description' => 'Can register new users'
        ]);

        $seeAllApps = Permission::create([
            'name' => 'See All Applications',
            'slug' => 'see.all.applications',
            'description' => 'Can view all applications'
        ]);

        $adminRole->attachPermission($createRatings);
        $adminRole->attachPermission($createUsers);
        $adminRole->attachPermission($seeAllApps);
        
        $readerRole->attachPermission($seeAllApps);

        User::find(1)->attachRole($adminRole);
       	User::find(2)->attachRole($adminRole);
    }
}
