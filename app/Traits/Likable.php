<?php

namespace App\Traits;

use App\Like;
use App\Likable as LikablePivot;

trait Likable
{
    public function likes()
    {
        return $this->morphToMany(Like::class, 'likable')
                    ->withTimestamps()
                    ->withPivot('user_id')
                    ->using(LikablePivot::class);
    }
}
