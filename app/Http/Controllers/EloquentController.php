<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;

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
}
