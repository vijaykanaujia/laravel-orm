<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function casting()
    {
        $result = User::select([
            'users.*',
            'last_commented_at' => Comment::selectRaw('MAX(created_at)')
                ->whereColumn('user_id', 'users.id'),
        ])->withCasts([
            'last_commented_at' => 'datetime:Y-m-d', // date and datetime works only for array or json result
        ])->get()->toJson();

        dump($result);
    }

    public function relationQuery()
    {
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
        // $result = Image::find(8);
        // dump($result->comments);

        // ManyToMany Polymorphic relationships
        // $result = User::find(1);
        // dump($result->likedRooms, $result->likedImages);
        $result = Room::find(6);
        dump($result->likes);
    }

    public function queryOnRelationship()
    {
        // $result = User::find(1)->comments()
        //     ->where('rating', '>', 3)
        //     ->orWhere('rating', '<', 2)
        //     ->get();
        // $result = User::find(1)->comments()
        //     ->where(function ($query) {
        //         return $query->where('rating', '>', 3)
        //             ->orWhere('rating', '<', 2);
        //     })
        //     ->get();

        // $result = User::has('comments', '>=', 6)->get();
        // $result = Comment::has('user.address')->get();

        // $result = User::whereHas('comments', function ($query) {
        //     $query->where('rating', '>', 2);
        // }, '>=', 2)->get();

        // $result = User::doesntHave('comments')->get(); // ->orDoesntHave

        // $result = User::whereDoesntHave('comments', function ($query) {
        //     $query->where('rating', '<', 2);
        // })->get(); // ->orWhereDoesntHave

        // $result = Reservation::whereDoesntHave('user.comments', function ($query) {
        //     $query->where('rating', '<', 2);
        // })->get(); // more realistic scenario: give me all posts written by users who rated by at lest 3 stars

        // $result = User::withCount('comments')->get();

        // $result = User::withCount([
        //     'comments',
        //     'comments as negative_comments_count' => function ($query) {
        //         $query->where('rating', '<=', 2);
        //     },
        // ])->get();

        // dump($result);
    }

    public function queryOnPolymorphicRelationship()
    {
        // $result = Comment::whereHasMorph('commentable', [Image::class, Room::class], function ($query, $type) {
        //     if ($type == Room::class) {
        //         $query->where('room_sizes', '<=', 2);
        //         $query->orWhere('room_sizes', '<=', 2);
        //     }
        //     if ($type == Image::class) {
        //         $query->where('path', 'like', '%lorem%');
        //     }
        // })->get();

        // $result = Comment::with(['commentable' => function ($morphTo) {
        //     $morphTo->morphWithCount([
        //         Room::class => ['comments'],
        //         Image::class => ['comments'],
        //     ]);
        // }])->find(6);

        $result = Comment::find(3)
            ->loadMorphCount('commentable', [
                Room::class => ['comments'],
                Image::class => ['comments'],
            ]);

        dump($result);
    }

    public function crudOnRelatedModel()
    {
        // $user = User::find(1);
        // $result = $user->address()->delete();
        // $result = $user->address()->saveMany([   // save(new Address)
        //     new Address(['number' => 1, 'street' => 'street', 'country' => 'USA'])
        // ]);

        // $result = $user->address()->createMany([ // create()
        //     ['number' => 2, 'street' => 'street2', 'country' => 'Mexico']
        // ]);

        // $user = User::find(2);
        // $address = Address::find(2);
        // $address->user()->associate($user);
        // $result = $address->save();

        // $address->user()->dissociate();
        // $result = $address->save();

        // $room = Room::find(1);
        // $result = $room->cities()->attach(1);
        // $result = $room->cities()->detach([1]); // without argument all cities will be detached

        $comment = Comment::find(1);
        $comment->content = 'Edit to this comment!';
        $result = $comment->save();

        dump($result);
    }

    public function performenceCompare()
    {
        // $result = User::with('comments')->get();
        // $result = DB::table('users')->join('comments', 'users.id', '=', 'comments.user_id')->get();
        // $result = DB::select('select * from users inner join comments on users.id = comments.user_id');
        dump($result);
    }
}
