<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
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
                ['created_at', '>', 'updated_at'], ['room_number', 'room_size']
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

    public function fulltextSearch(){
        // DB::statement('ALTER TABLE comments ADD FULLTEXT fulltext_index(content)');
        $result = DB::table('comments')->whereRaw("MATCH(content) AGAINST(? IN BOOLEAN MODE)", ['+inventore -corporis'])->get();
        // $result = DB::table('comments')->where('content', 'like', '%inventore%')->get();
        dump($result);
    }

    public function dbRawQuery(){
         $result = DB::table('comments')
        // ->select(DB::raw('count(user_id) as number_of_comments, users.name'))
        ->selectRaw('count(user_id) as number_of_comments, users.name',[])
        ->join('users','users.id','=','comments.user_id')
        ->groupBy('user_id')
        ->get();
        dd($result);
    }
}
