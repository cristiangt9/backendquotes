<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
