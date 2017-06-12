<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Likable extends MorphPivot
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likable()
    {
        return $this->morphTo();
    }
}
