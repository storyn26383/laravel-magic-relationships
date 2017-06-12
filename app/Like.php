<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const BIG_HEART = 1;

    const S77 = 2;

    protected $fillable = ['type'];
}
