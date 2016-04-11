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

        if (! Permission::whereSlug('create.ratings')->exists() ) {
            $ratingsPermission = Permission::create([
                'name' => 'Create Ratings',
                'slug' => 'create.ratings',
                'description' => 'Can rate objects'
            ]);
        }

        if (! Permission::whereSlug('create.users')->exists() ) {
            $usersPermission = Permission::create([
                'name' => 'Create Users',
                'slug' => 'create.users',
                'description' => 'Can register new users'
            ]);
        }

        if (! Permission::whereSlug('edit.applications')->exists() ) {
            $editAppsPermission = Permission::create([
                'name' => 'Edit Applications',
                'slug' => 'edit.applications',
                'description' => 'Can edit application values'
            ]);
        }

        if (! Permission::whereSlug('see.all.applications')->exists() ) {
            $allAppsPermission = Permission::create([
                'name' => 'See All Applications',
                'slug' => 'see.all.applications',
                'description' => 'Can view all applications'
            ]);
        }


        if (! Role::whereSlug('admin')->exists() ) {
            $adminRole = Role::create([
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrators have access to everything'
            ]);

            User::find(1)->attachRole($adminRole);
            User::find(2)->attachRole($adminRole);
        }

        if (! Role::whereSlug('reader')->exists() ) {
            $readerRole = Role::create([
                'name' => 'Reader',
                'slug' => 'reader',
                'description' => 'Readers can read all applications, but cannot rate or comment on them'
            ]);
        }

        if (! Role::whereSlug('editor')->exists() ) {
            $editorRole = Role::create([
                'name' => 'Editor',
                'slug' => 'editor',
                'description' => 'Editors can read, rate, and comment on all applications'
            ]);
        }

        $adminRole = Role::whereSlug('admin')->first();
        $editorRole = Role::whereSlug('editor')->first();
        $ratingsPermission = Permission::whereSlug('create.ratings')->first();
        $usersPermission = Permission::whereSlug('create.users')->first();
        $editAppsPermission = Permission::whereSlug('edit.applications')->first();

        $adminRole->attachPermission($ratingsPermission);
        $adminRole->attachPermission($usersPermission);
        $adminRole->attachPermission($editAppsPermission);

        $editorRole = Role::whereSlug('editor')->first();
        $editorRole->attachPermission($editAppsPermission);
        $editorRole->attachPermission($ratingsPermission);
        $editorRole->attachPermission($usersPermission);

    }
}
