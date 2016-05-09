<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testNameFormatting()
    {
        $user = factory(App\User::class)->create([
            'name' => 'lower case'
        ]);

        $this->assertEquals('Lower Case', $user->name);
    }

    public function test_user_can_update_password()
    {
        $password = "TESTING";

        $user = factory(App\User::class)->create([
            'password' => bcrypt($password)
        ]);

        $this->actingAs($user)
             ->visit("users/{$user->id}")
             ->type($password, 'password')
             ->type($password, 'password_confirm')
             ->press('Update Password');

        $this->assertTrue($user->checkPassword($password));
    }

    public function test_admin_can_update_password()
    {
        $password = "TESTING";
        $admin = $this->makeAdmin();
        $user = factory(App\User::class)->create([
            'password' => bcrypt($password)
        ]);

        $this->actingAs($admin)
             ->visit("users/{$user->id}")
             ->type($password, 'password')
             ->type($password, 'password_confirm')
             ->press('Update Password');

        $this->assertTrue($user->checkPassword($password));
    }
}
