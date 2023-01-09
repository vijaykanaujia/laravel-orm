<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // DB::listen(function ($query) {
        //     $arr = [
        //         'sql' => $query->sql,
        //         'binding' => $query->binding ?? 'no binding',
        //         'time' => $query->time,
        //     ];
        //     dump($arr);
        // });
    }
}
