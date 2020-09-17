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

Route::get('s3',function(){
    // Okay!
    // $bucket = Storage::disk('nba_s3');
    $bucket = Storage::disk('kore_s3');
    $files = $bucket->files();
    dd($files);
});

Route::get('brothers',function(){
    $games = Modules\Stats\Entities\Game::where('status','=',3)->whereHas('officials',function(Illuminate\Database\Eloquent\Builder $query){
        $query->where('first_name','=','Tony')->where('last_name','=','Brothers');
    })->orderBy('date_time','asc')->get();
    $wins = [];
    $losses = [];
    foreach($games as $game){
        if($game->celtics->pivot->s > $game->opponent->pivot->s){
            array_push($wins,$game);
        }
        else{
            array_push($losses,$game);
        }
    }
    return 'Of '.count($games).' total games where Tony Brothers has officiated (starting '.$games->first()->date_time->toDayDateTimeString().' to '.$games->last()->date_time->toDayDateTimeString().'), the Celtics have won '.count($wins).' games and lost '.count($losses).'.';
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

Route::get('/historical-games',function(){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://stats.nba.com/stats/scoreboardV2?DayOffset=0&LeagueID=00&gameDate=11/01/1946",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Host: stats.nba.com",
        "x-nba-stats-origin: stats"
    ),
    ));

    $response = curl_exec($curl);


    curl_close($curl);

    $status = curl_getinfo($response);
    return $status;

    return $response;

    $all_seasons_json = file_get_contents('http://stats.nba.com/stats/teamyearbyyearstats?LeagueID=00&PerMode=Totals&SeasonType=Regular+Season&TeamID=1610612738');
    $all_seasons = json_decode($all_seasons_json);
    dd($all_seasons);
    foreach($all_seasons->resultSets[0]->rowSet as $season_year) {
        $season_games = array();
        $pre_season_games_json = file_get_contents('http://stats.nba.com/stats/teamgamelog?LeagueID=00&Season='.$season_year[3].'&SeasonType=Preseason&TeamID=1610612738');
        $pre_season_games = json_decode($pre_season_games_json);
        foreach($pre_season_games->resultSets[0]->rowSet as $game) {
            $home_away = 'away';
            if(strpos($game[3],'vs.') !== false) {
                $home_away = 'home';
            }
            $season_games[] = (object) [
                'gid' => $game[1],
                'year' => $season_year[3],
                'location' => $home_away,
                'stype' => 'Preseason',
                'stype_db' => 'preseason',
                'date' => \Carbon\Carbon::createFromTimeStamp(strtotime($game[2]))->toDateTimeString()
            ];
        }
        $regular_season_games_json = file_get_contents('http://stats.nba.com/stats/teamgamelog?LeagueID=00&Season='.$season_year[3].'&SeasonType=Regular+Season&TeamID=1610612738');
        $regular_season_games = json_decode($regular_season_games_json);
        foreach($regular_season_games->resultSets[0]->rowSet as $game) {
            $home_away = 'away';
            if(strpos($game[3],'vs.') !== false) {
                $home_away = 'home';
            }
            $season_games[] = (object) [
                'gid' => $game[1],
                'year' => $season_year[3],
                'location' => $home_away,
                'stype' => 'Regular+Season',
                'stype_db' => 'regular',
                'date' => \Carbon\Carbon::createFromTimeStamp(strtotime($game[2]))->toDateTimeString()
            ];
        }
        $post_season_games_json = file_get_contents('http://stats.nba.com/stats/teamgamelog?LeagueID=00&Season='.$season_year[3].'&SeasonType=Playoffs&TeamID=1610612738');
        $post_season_games = json_decode($post_season_games_json);
        foreach($post_season_games->resultSets[0]->rowSet as $game) {
            $home_away = 'away';
            if(strpos($game[3],'vs.') !== false) {
                $home_away = 'home';
            }
            $season_games[] = (object) [
                'gid' => $game[1],
                'year' => $season_year[3],
                'location' => $home_away,
                'stype' => 'Playoffs',
                'stype_db' => 'postseason',
                'date' => \Carbon\Carbon::createFromTimeStamp(strtotime($game[2]))->toDateTimeString()
            ];
        }
        foreach($season_games as $game) {
            $game_file_path = database_path().'/backups/box_scores/box_'.$game->year.'_'.$game->gid.'.json';
            if(\File::exists($game_file_path)) {
                echo 'Box score exists. Moving on.<br>';
            }
            else {
                $game_box_array = array();
                $game_box_json = file_get_contents('http://stats.nba.com/stats/boxscoretraditionalv2?EndPeriod=10&EndRange=28800&GameID='.$game->gid.'&RangeType=0&Season='.$game->year.'&SeasonType='.$game->stype.'&StartPeriod=1&StartRange=0');
                $game_box = json_decode($game_box_json);
                foreach($game_box->resultSets[1]->rowSet as $team) {
                    if($team[3] == 'BOS') {
                        if($game->location == 'home') {
                            $home_info = (object) [
                                'city' => $team[4],
                                'name' => $team[2],
                                'abbr' => $team[3],
                                'nba_id' => $team[1],
                                'score' => $team[23]
                            ];
                        }
                        else {
                            $visitor_info = (object) [
                                'city' => $team[4],
                                'name' => $team[2],
                                'abbr' => $team[3],
                                'nba_id' => $team[1],
                                'score' => $team[23]
                            ];
                        }
                    }
                    else {
                        if($game->location == 'home') {
                            $visitor_info = (object) [
                                'city' => $team[4],
                                'name' => $team[2],
                                'abbr' => $team[3],
                                'nba_id' => $team[1],
                                'score' => $team[23]
                            ];
                        }
                        else {
                            $home_info = (object) [
                                'city' => $team[4],
                                'name' => $team[2],
                                'abbr' => $team[3],
                                'nba_id' => $team[1],
                                'score' => $team[23]
                            ];
                        }
                    }
                }
                $game_box_array[] = (object) [
                    'gid' => $game->gid,
                    'year' => $game->year,
                    'date' => $game->date,
                    'location' => $game->location,
                    'season_type' => $game->stype_db,
                    'visitor' => $visitor_info,
                    'home' => $home_info
                ];
                foreach($game_box->resultSets[0]->rowSet as $player) {
                    if($player[7] == '') {
                        $is_out = false;
                        $out_string = null;
                    }
                    else {
                        $is_out = true;
                        $out_string = $player[7];
                    }
                    if($player[6] == '') {
                        $is_starter = false;
                    }
                    else {
                        $is_starter = true;
                    }
                    $game_box_array[] = (object) [
                        'tid' => $player[1],
                        'pid' => $player[4],
                        'full_name' => $player[5],
                        'min' => $player[8],
                        'fgm' => $player[9],
                        'fga' => $player[10],
                        'tpm' => $player[12],
                        'tpa' => $player[13],
                        'ftm' => $player[15],
                        'fta' => $player[16],
                        'oreb' => $player[18],
                        'dreb' => $player[19],
                        'reb' => $player[20],
                        'ast' => $player[21],
                        'stl' => $player[22],
                        'blk' => $player[23],
                        'tov' => $player[24],
                        'pf' => $player[25],
                        'pts' => $player[26],
                        'pm' => $player[27],
                        'starter' => $is_starter,
                        'out' => $is_out,
                        'out_reason' => $out_string
                    ];
                }
                \File::put($game_file_path,serialize($game_box_array));
                echo 'Added '.$game_file_path.'.<br>';
            }
        }
    }
    echo 'Done!';
  });
