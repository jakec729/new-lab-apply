<?php

use App\Application;
use App\User;
use Bican\Roles\Models\Role;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function makeApp()
    {
        return factory(Application::class)->create();
    }

    protected function makeReader()
    {
        $user = factory(User::class)->create();
        $role = Role::where('slug', 'reader')->first();
        $user->attachRole($role);
        $user = $user->fresh();

        return $user;
    }

    protected function makeEditor()
    {
        $user = factory(User::class)->create();
        $role = Role::where('slug', 'editor')->first();
        $user->attachRole($role);
        $user = $user->fresh();

        return $user;
    }

    protected function makeAdmin()
    {
        $user = factory(User::class)->create();
        $role = Role::where('slug', 'admin')->first();
        $user->attachRole($role);
        $user = $user->fresh();

        return $user;
    }

    protected function makeReviewer()
    {
        $user = $this->makeUser();
        $role = Role::where('slug', 'reviewer')->first();
        $user->attachRole($role);
        $user = $user->fresh();

        return $user;
    }

    protected function makeUser()
    {
        return factory(App\User::class)->create();
    }
}
