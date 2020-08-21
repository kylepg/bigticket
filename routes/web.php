<?php

use Illuminate\Support\Facades\Route;

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

Route::get('login', 'Auth\LoginController@redirectToAzure')->name('login');
Route::get('login/callback', 'Auth\LoginController@handleAzureCallback')->name('loginCallback');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', function () {
    if(\Auth::check()){
        // dd(\Auth::user());
        return view('welcome');
    }
    return view('welcome');
});


Route::get('modules',function(){
    dd(collect([]));
});

Route::get('article',function(){
    $article = Modules\Content\Entities\DrupalArticle::inRandomOrder()->first();
    return $article->body_raw;
});

Route::get('team',function(){
    // $team = Modules\Stats\Entities\Team::inRandomOrder()->first();
    $team = Modules\Stats\Entities\Team::where('abbreviation','=','BOS')->first();
    dd($team->players);
});


Route::get('game',function(){
    $game = Modules\Stats\Entities\Game::latest()->first();
});

Route::get('player/{pid}',function($pid){
    if(!empty($pid)){
        $player = Modules\Stats\Entities\Player::where('pid','=',$pid)->first();
        $smart = Modules\Stats\Entities\Player::where('first_name','=','Marcus')->where('last_name','=','Smart')->first();
        if(!empty($player)){
            $plays = $player->primaryPlays()->whereAssistedBy($smart)->whereDunk()->whereMade()->whereOnFastBreak()->get();
            echo count($plays).' matching plays.<br><br>';
            foreach($plays as $play){
                echo $play->description.'<br>';
            }
            return;
        }
        return;
    }
    return 'Player not found.';
});
