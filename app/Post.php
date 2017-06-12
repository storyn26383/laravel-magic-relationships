<?php

namespace App;

use App\Traits\Likable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Likable as LikableContract;

class Post extends Model implements LikableContract
{
    use Likable;

    protected $fillable = ['title', 'content'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
