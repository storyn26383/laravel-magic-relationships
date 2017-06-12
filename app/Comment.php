<?php

namespace App;

use App\Traits\Likable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Likable as LikableContract;

class Comment extends Model implements LikableContract
{
    use Likable;

    protected $fillable = ['content', 'user_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
