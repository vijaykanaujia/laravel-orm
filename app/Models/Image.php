<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function imageable(){
        return $this->morphTo();
    }

    public function notdependoncoumn(){
        return $this->morphTo(__FUNCTION__, 'imageable_type', 'imageable_id');
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes(){
        return $this->morphToMany(User::class, 'likeable');
    }
}
