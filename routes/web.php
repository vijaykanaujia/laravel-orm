<?php

use App\Http\Controllers\EloquentController;
use App\Http\Controllers\QueryController;
use App\Models\User;
use App\Services\PaypalAPI;
use App\Services\PayuAPI;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (PayuAPI $paypalAPI) {
    // dd($paypalAPI->checkout());
    return view('welcome');
});
Route::get('where-clause', [QueryController::class, 'whereClause']);
Route::get('fulltext-search', [QueryController::class, 'fulltextSearch']);
Route::get('dbraw', [QueryController::class, 'dbRawQuery']);
Route::get('join', [QueryController::class, 'joinQueries']);
Route::get('orm', [EloquentController::class, 'orm']);
Route::get('queryScope', [EloquentController::class, 'queryScope']);
Route::get('casting', [EloquentController::class, 'casting']);
Route::get('relationQuery', [EloquentController::class, 'relationQuery']);
