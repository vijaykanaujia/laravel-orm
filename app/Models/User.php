<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'meta' => 'json',
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'user_id', 'id')->withDefault(['country' => 'no addrees attached yet']); // 2nd 3rd args optional
        // withDefault() only for: belongsTo, hasOne, hasOneThrough, and morphOne relations
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id'); // 2nd 3rd args optional
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function likedImages()
    {
        return $this->morphedByMany(Image::class, 'likeable');
    }

    public function likedRooms()
    {
        return $this->morphedByMany(Room::class, 'likeable');
    }
}
