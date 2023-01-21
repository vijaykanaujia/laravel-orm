<?php

namespace App\Http\Controllers;

use App\Services\PaypalAPI;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public $paypalService;

    public function __construct()
    {
        $this->paypalService = new PaypalAPI('12345678');
    }
    public function whereClause()
    {
        $result = DB::table('rooms')
            ->where([['room_number', '<=', 10], ['room_size', 2]])
            ->whereIn('id', [1, 2, 3]) //similer ->whereNotIn('id', [1,2,3])
            ->whereNotNull('description') //similer ->wherNull('description')
            ->whereDate('created_at', 'now')
            ->whereMonth('created_at', '5')
            ->whereDay('created_at', '13')
            ->whereYear('created_at', '2020')
            ->whereTime('created_at', '=', '12:25:10')
            ->whereColumn('created_at', '>', 'updated_at')
            ->whereColumn([ //multiple condition
                ['created_at', '>', 'updated_at'], ['room_number', 'room_size'],
            ])
            ->whereExists(function ($query) { //subquery
                $query->select('id')
                    ->from('reservations')
                    ->whereRaw('reservations.room_id = rooms.id')
                    ->where('check_in', '=', 'now')
                    ->limit(1);
            })
            ->get();
        dd($result);
        //suppose your column is meta and it have data like
        //  {
        //    'skills': 'laravel',
        //    'settings' : {
        //        'site_background' : 'black',
        //        'site_title' : 'title'
        //        }
        //   }
        //then you are able to search like this
        $users = DB::table('users')
            ->whereJsonContains('meta->skills', 'laravel')
            ->whereJsonContains('meta->settings->site_title', 'title')
            ->get();
        dump($result);
    }

    public function fulltextSearch()
    {
        // DB::statement('ALTER TABLE comments ADD FULLTEXT fulltext_index(content)');
        $result = DB::table('comments')->whereRaw("MATCH(content) AGAINST(? IN BOOLEAN MODE)", ['+inventore -corporis'])->get();
        // $result = DB::table('comments')->where('content', 'like', '%inventore%')->get();
        dump($result);
    }

    public function dbRawQuery()
    {
        dd($this->paypalService->pay());
        // $result = DB::table('comments')
        // // ->select(DB::raw('count(user_id) as number_of_comments, users.name'))
        // ->selectRaw('count(user_id) as number_of_comments, MAX(users.name)',[])
        // ->join('users','users.id','=','comments.user_id')
        // ->groupBy('user_id')
        // ->get();

        // $result = DB::table('users')
        // ->orderByRaw('updated_at - created_at ASC')
        // ->get();

        // $result = DB::table('users')
        //         ->selectRaw('LENGTH(name) as name_lenght, name')
        //         ->orderByRaw('LENGTH(name) DESC')
        //         ->get();

        // $result = DB::table('comments')
        // ->selectRaw('count(id) as num_of_5rating,rating')
        // ->groupBy('rating')
        // ->having('rating', '=', 5)
        // ->get();
        // $result = DB::table('comments')
        // // ->skip(2)
        // // ->take(2)
        // ->offset(3)
        // ->limit(3)
        // ->get();

        $result = DB::table('comments')
            ->orderBy('id')
            ->chunkById(2, function ($q) {
                foreach ($q as $k => $v) {
                    if ($v->id == 5) {
                        return false;
                    }
                }
            });
        dump($result);
    }

    public function joinQueries()
    {
        // $result = DB::table('reservations')
        //     ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
        //     ->join('users', 'reservations.user_id', '=', 'users.id')
        //     ->where('rooms.id', '>', 3)
        //     ->where('users.id', '>', 1)
        //     ->get();

        // $result = DB::table('reservations')
        //     ->join('rooms', function ($q) {
        //         $q->on('reservations.room_id', '=', 'rooms.id')
        //             ->where('rooms.id', '>', 3);
        //     })
        //     ->join('users', function ($q) {
        //         $q->on('reservations.user_id', '=', 'users.id')
        //             ->where('users.id', '>', 1);
        //     })
        //     ->get();

        $result = DB::table('rooms')
        ->selectRaw('room_size,user_id,max(name), count(reservations.id) as total_reservation')
        ->leftJoin('reservations','reservations.room_id', '=', 'rooms.id')
        ->leftJoin('users','users.id', '=', 'reservations.user_id')
        ->groupBy('room_size', 'user_id')
        ->get();

        dump($result);

    }
}
