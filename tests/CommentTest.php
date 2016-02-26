<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
	use DatabaseTransactions;

	public function testPostHasManyComments()
	{
		$user = factory(App\User::class)->create();

		$post = factory(App\Movie::class)->create();

		$comment = factory(App\Comment::class)->create([
			'movie_id' => $post->id,
			'user_id' => $user->id
		]);

		// dd($post->comments);

		$this->assertEquals($post->comments->first()->id, $comment->id);
	}

	public function testAddACommentFromForm()
	{
		$user = factory(App\User::class)->create();
		$movie = factory(App\Movie::class)->create();

		$this->actingAs($user)
		     ->withSession(['foo' => 'bar'])
		     ->visit("/movies/{$movie->id}")
		     ->type('Test Body Sentence', 'body')
		     ->press('Add Comment')
		     ->see('Test Body Sentence');
	}
}
