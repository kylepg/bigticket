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

Route::get('today',function(){
    // $test = Modules\Stats\Entities\Game::inRandomOrder()->first();
    // return get_class($test);
    // simpleSetting('is_celtics_gameday',false);

    // if(simpleSetting('is_celtics_gameday')){
    //     return 'gameday';
    // }
    // return 'not gameday';
    $league = Modules\Stats\Entities\League::where('name','=','NBA')->first();
    $season_year = (int)config('nba.season_year');
    // $now = Carbon\Carbon::now();
    // $month_code = $now->format('m');

    if(!empty($league)){
        $client = new GuzzleHttp\Client();

        //!! THIS IS FOR MONTH BY MONTH SCHEDULE !!//
        // $url = 'https://data.nba.com/data/v2015/json/mobile_teams/'.$league->code.'/'.$season_year.'/league/'.$league->lid.'_league_schedule_'.$month_code.'.json';

        $url = 'https://data.nba.com/data/v2015//json/mobile_teams/'.$league->code.'/'.$season_year.'/scores/'.$league->lid.'_todays_scores.json';
        $result = $client->get($url, [
            'http_errors' => false
        ]);
        if($result->getStatusCode() === 200){
            $scores_data = @json_decode($result->getBody()->getContents());
            if(!empty($scores_data) && property_exists($scores_data,'gs') && property_exists($scores_data->gs,'g')){
                dd($scores_data->gs->g);
                foreach($scores_data->gs->g as $this_game){
                    $game = Modules\Stats\Entities\Game::where('gid','=',$this_game->gid)->first();
                    if(!empty($game)){
                        echo 'Game '.$game->gid.' found<br>';
                    }
                    echo 'Game id '.$this_game->gid.'<br>';
                }
            }
        }
    }
});
