<?php

namespace Tests\Unit;

use App\Like;
use App\Post;
use App\User;
use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RelationshipsTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanPostAPost()
    {
        // 1. User
        $user = factory(User::class)->create();

        // 2. User Post a Post
        $attributes = [
            'title' => 'Hello World',
            'content' => 'Hello World',
        ];

        $post = $user->posts()->create($attributes);

        // 3. Check User ID of Post
        $this->assertTrue($post->user->is($user));

        // 4. Check Database
        $this->assertDatabaseHas('posts', $attributes);
    }

    public function testUserCanCommentOnAPost()
    {
        // 1. User
        $user = factory(User::class)->create();

        // 2. Post
        $post = factory(Post::class)->create();

        // 3. User Comment On a Post
        $attributes = ['content' => 'Hello World'];

        $comment = $user->comment($post, $attributes);

        // 4. Check User ID and Post ID of Comment
        $this->assertTrue($comment->post->is($post));
        $this->assertTrue($comment->user->is($user));

        // 5. Check Database
        $this->assertDatabaseHas('comments', $attributes);
    }

    public function testUserCanLikeAPost()
    {
        // 1. User
        $user = factory(User::class)->create();

        // 2. Post
        $post = factory(Post::class)->create();

        // 3. Like
        $like = Like::create(['type' => Like::BIG_HEART]);

        // 4. User Like a Post
        $user = $user->like($post, Like::BIG_HEART);

        // 5. Check Likes of Post Should Contains Like
        $this->assertTrue($post->likes->contains($like));

        // 6. Check Like is Liked by User
        $this->assertTrue($post->likes->first()->pivot->user->is($user));

        // 7. Check Like Type
        $this->assertEquals(Like::BIG_HEART, $post->likes->first()->type);
    }

    public function testUserCanLikeAComment()
    {
        // 1. User
        $user = factory(User::class)->create();

        // 2. Comment
        $comment = factory(Comment::class)->create();

        // 3. Like
        $like = Like::create(['type' => Like::S77]);

        // 4. User Like a Comment
        $user = $user->like($comment, Like::S77);

        // 5. Check Likes of Post Should Contains Like
        $this->assertTrue($comment->likes->contains($like));

        // 6. Check Like is Liked by User
        $this->assertTrue($comment->likes->first()->pivot->user->is($user));

        // 7. Check Like Type
        $this->assertEquals(Like::S77, $comment->likes->first()->type);
    }

    public function testGetUserLikes()
    {
        // 1. User
        $user = factory(User::class)->create();

        // 2. Post
        $post = factory(Post::class)->create();

        // 3. Comment
        $comment = factory(Comment::class)->create();

        // 4. Like
        Like::create(['type' => Like::BIG_HEART]);
        Like::create(['type' => Like::S77]);

        // 5. User Like Post and Comment
        $user->like($post, Like::BIG_HEART);
        $user->like($comment, Like::S77);

        // 6. Check User Likes Contains Post and Comment
        $this->assertTrue($user->likes->contains($post));
        $this->assertTrue($user->likes->contains($comment));
    }
}
