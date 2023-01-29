<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $touches = ['user'];

    // protected $casts = [
    //     'rating' => 'float',
    // ];

    // retrieved, creating, created, updating, updated, saving, saved, deleting, deleted, restoring, restored
    // When issuing a mass update or delete via Eloquent, the saved, updated, deleting, and deleted model events will not be fired for the affected models. This is because the models are never actually retrieved when issuing a mass update or delete.
    // protected $dispatchesEvents = [
    //     'saved' => 'class to handle saved event',
    //     'deleted' => 'class to deleted saved event'
    // ];

    // protected $fillable = ['rating', 'content', 'user_id'];
    protected $guarded = [];

    // protected static function booted()
    // {
    //     static::addGlobalScope('rating', function (Builder $builder) {
    //         $builder->where('rating', '>', 2);
    //     });

    //     //on data retreived event
    //     static::retrieved(function ($comment) {
    //         // echo $comment->rating;
    //         echo $comment->who_what;
    //     });
    // }

    // public function scopeRating($query, int $value = 2)
    // {
    //     return $query->where('rating', '>', $value);
    // }

    //accessor - manipulate model properties when accessing them
    // public function getRatingAttribute($value)
    // {
    //     return $value + 10;
    // }

    // public function getWhoWhatAttribute()
    // {
    //     return "user {$this->user_id} rates {$this->rating}";
    // }

    // //mutators - manipulate model properties when saving them
    // public function setRatingAttribute($value)
    // {
    //     $this->attributes['rating'] = $value + 1;
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->hasOneThrough(Address::class, User::class, 'id', 'user_id', 'user_id', 'id')->select('country as name');
    }

    public function commentable(){
        return $this->morphTo();
    }

}
