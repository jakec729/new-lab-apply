<?php

use App\Repositories\UserRepository;
use App\User;
use Bican\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserRepositoryTest extends TestCase
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

    public function testReviewers()
    {
    	$users = factory(User::class, 10)->create();
    	$first = $users->shift();

    	$role = factory(Role::class)->create();
    	$first->attachRole($role);

    	$user_rep = new UserRepository();
    	$reviewers = $user_rep->reviewers();

    	$this->assertTrue($reviewers->where('id', $first->id)->count() == 0);
    }

    public function test_repository_finds_reviewers()
    {
        DB::table('users')->truncate();
        DB::table('role_user')->truncate();

        $reviewer = $this->makeReviewer();
        $reviewers = UserRepository::reviewers();

        $this->assertEquals($reviewers->count(), 1);
    }

    public function test_repository_finds_editors()
    {
        DB::table('users')->truncate();
        DB::table('role_user')->truncate();

        $this->makeEditor();
        $this->makeEditor();

        $editors = UserRepository::editors();

        $this->assertEquals($editors->count(), 2);
    }
}
