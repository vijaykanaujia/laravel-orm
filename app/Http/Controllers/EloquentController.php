<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;

class EloquentController extends Controller
{
    public function orm()
    {
        //$result = Room::all(); //use all() when no quiries
        //$result = Room::where('price', '<', 400)->get(); //use get() when have queries

        // $result = User::select('name', 'email')
        //     ->addSelect(['worst_rating' => Comment::select('rating')
        //             ->whereColumn('user_id', 'users.id')
        //             ->orderBy('rating', 'asc')
        //             ->limit(1),
        //     ])->get()->toArray();

        // $result = User::orderByDesc( // asc default without 'Desc' part
        //     Reservation::select('check_in')
        //         ->whereColumn('user_id', 'users.id')
        //         ->orderBy('check_in', 'desc') // asc default without argument
        //         ->limit(1)
        // )->select('id', 'name')->get()->toArray();

        $result = Reservation::chunk(2, function ($reservations) {
            foreach ($reservations as $reservation) {
                dump($reservation->id);
            }
        }); // uses less memory than get() and cursor() but takes longer than get() and cursor(), the bigger chunk set is the less time a query takes but memory usage increases

        foreach (Room::cursor() as $reservation) {
            dump($reservation->id);
        } // takes faster than get() and chunk() but uses more memory than chunk() (not as much as get() method)

        // dump($result);
    }

    public function queryScope()
    {
        //get data with global scope that define in model
        $result = Comment::all();

        // get data without applying global scope in query
        // $result = Comment::withoutGlobalScope('rating')->get();

        //get data using local scope and global scope
        // $result = Comment::rating(1)->get();

        //get data using local scope and disable global scope
        // $result = Comment::withoutGlobalScope('rating')->rating(1)->get();

        dump($result);
    }

    public function casting(){
        $result = User::select([
            'users.*',
            'last_commented_at' => Comment::selectRaw('MAX(created_at)')
                ->whereColumn('user_id', 'users.id')
        ])->withCasts([
            'last_commented_at' => 'datetime:Y-m-d' // date and datetime works only for array or json result
        ])->get()->toJson();

        dump($result);
    }

    public function relationQuery(){
        //hasOneThrough relationships
        // $result = City::with('rooms')->find(1);
        // $result = Comment::find(5);
        // dump($result->country);

        //hasManyThrough relationships
        // $result = Company::find(1);
        // dump($result->reservations);

        //morphOne relationships
        // $result = User::find(3);
        // $result = Image::find(3);
        // dump($result->imageable);

        //morphMany relationships
        // $result = Room::find(6);
        $result = Image::find(8);
        dump($result->comments);
    }
}
