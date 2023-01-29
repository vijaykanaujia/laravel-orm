<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'city_room', 'city_id', 'room_id')->withPivot('room_id', 'city_id');
        // 1st 2nd 3rd args are optional
        // you can also use withPivot('column_name')
        // or wherePivotIn('column_name', ['column_name', ...])
        // or wherePivotNotIn('column_name', ['column_name', ...])
        // or wherePivot('column_name', 'column_value', 'column_value2')
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
