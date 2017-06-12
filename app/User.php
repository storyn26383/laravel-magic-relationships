<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Contracts\Likable as LikableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comment(Post $post, $attributes)
    {
        return $post->comments()->create(array_merge($attributes, [
            'user_id' => $this->id,
        ]));
    }

    public function like(LikableContract $likable, $type)
    {
        $like = Like::whereType($type)->firstOrFail();

        $likable->likes()->attach([
            $like->id => [
                'user_id' => $this->id,
                'like_id' => $like->id,
            ]
        ]);

        return $this;
    }

    public function getLikesAttribute()
    {
        return $this->belongsToMany(Like::class, 'likables')
                    ->withPivot('likable_type', 'likable_id')
                    ->using(Likable::class)
                    ->get()
                    ->map(function ($like) {
                        return $like->pivot->likable;
                    });
    }
}
