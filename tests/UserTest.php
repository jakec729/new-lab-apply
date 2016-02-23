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

    public function testRegisterRedirectIfGuest()
    {
    	$this->visit('/register')
    		 ->see('<i class="fa fa-btn fa-sign-in"></i>Login');
    }

    public function testRouteIndex()
    {
        $user = factory(App\User::class)->create();
        
        $this->visit('/users')
             ->see('<h1>Users</h1>')
             ->see($user->name);
    }
}
