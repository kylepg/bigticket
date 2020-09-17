<?php

namespace Modules\Stats\Database\Seeders;

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleClient;

use Modules\Stats\Entities\BoxScore;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\Official;
use Modules\Stats\Entities\Player;

class BoxScoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //!! KEEPING MODEL GUARDS ON UNLESS WE RUN INTO ISSUES !!//
        /*
        BoxScore::unguard();
        Game::unguard();
        Player::unguard();
        */

        \DB::disableQueryLog();

        $seeder_start = microtime(true);
        $client = new GuzzleClient();
        $games = Game::all();
        $this->command->info('Getting box score data (for teams and players) for all games in the database ('.count($games).' games).');
        foreach($games as $this_game){
            $game_start = microtime(true);
            $url = 'https://data.nba.com/data/v2015/json/mobile_teams/nba/'.$this_game->season_year.'/scores/gamedetail/'.$this_game->gid.'_gamedetail.json';
            $result = $client->get($url,['http_errors' => false]);
            if($result->getStatusCode() === 200){
                $game_data = @json_decode($result->getBody()->getContents());
                if(!empty($game_data) && property_exists($game_data,'g')){
                    $game = $game_data->g;
                    // POPULATE MORE GAME STATS
                    $this->command->info('Getting game information for gid '.$this_game->gid);
                    $this_game->period = (int)$game->p;
                    $this_game->attendance = (int)$game->at;
                    if(gettype($game->dur) === 'string' && preg_match('/\d?\d\:\d\d(\.\d\d)?/',$game->dur)){
                        $duration_array = explode(':',$game->dur);
                        $duration_min = ((int)$duration_array[0] * 60) + (int)$duration_array[1];
                        $this_game->duration = $duration_min;
                    }
                    $this_game->clock = $game->cl;
                    $this_game->save();

                    if(property_exists($game,'offs') && property_exists($game->offs,'off') && !empty($game->offs->off)){
                        $officials_array = [];
                        foreach($game->offs->off as $official){
                            $this_official = Official::updateOrCreate(
                                [
                                    'first_name' => $official->fn,
                                    'last_name' => $official->ln

                                ],
                                [
                                    'jersey' => $official->num
                                ]
                            );
                            array_push($officials_array,$this_official->id);
                        }
                        $this_game->officials()->sync($officials_array);
                    }

                    // DEFINE TEAMS PIVOT TABLE ARRAY
                    $teams_pivot_data = [];
                    $teams_array = [
                        'hls' => 'home',
                        'vls' => 'visitor'
                    ];
                    foreach($teams_array as $key => $scope){
                        $teams_pivot_data[$this_game->$scope->id] = [
                            's' => (int)$game->$key->s,
                            'role' => $scope,
                            'q1' => (int)$game->$key->q1,
                            'q2' => (int)$game->$key->q2,
                            'q3' => (int)$game->$key->q3,
                            'q4' => (int)$game->$key->q4,
                            'ot1' => (int)$game->$key->ot1,
                            'ot2' => (int)$game->$key->ot2,
                            'ot3' => (int)$game->$key->ot3,
                            'ot4' => (int)$game->$key->ot4,
                            'ot5' => (int)$game->$key->ot5,
                            'ot6' => (int)$game->$key->ot6,
                            'ot7' => (int)$game->$key->ot7,
                            'ot8' => (int)$game->$key->ot8,
                            'ot9' => (int)$game->$key->ot9,
                            'ot10' => (int)$game->$key->ot10,
                            'ftout' => (int)$game->$key->ftout,
                            'stout' => (int)$game->$key->stout
                        ];
                        if(property_exists($game->$key,'tstsg')){
                            $teams_pivot_data[$this_game->$scope->id]['fga'] = property_exists($game->$key->tstsg,'fga') ? (int)$game->$key->tstsg->fga : 0;
                            $teams_pivot_data[$this_game->$scope->id]['fgm'] = property_exists($game->$key->tstsg,'fgm') ? (int)$game->$key->tstsg->fgm : 0;
                            $teams_pivot_data[$this_game->$scope->id]['tpa'] = property_exists($game->$key->tstsg,'tpa') ? (int)$game->$key->tstsg->tpa : 0;
                            $teams_pivot_data[$this_game->$scope->id]['tpm'] = property_exists($game->$key->tstsg,'tpm') ? (int)$game->$key->tstsg->tpm : 0;
                            $teams_pivot_data[$this_game->$scope->id]['fta'] = property_exists($game->$key->tstsg,'fta') ? (int)$game->$key->tstsg->fta : 0;
                            $teams_pivot_data[$this_game->$scope->id]['ftm'] = property_exists($game->$key->tstsg,'ftm') ? (int)$game->$key->tstsg->ftm : 0;
                            $teams_pivot_data[$this_game->$scope->id]['oreb'] = property_exists($game->$key->tstsg,'oreb') ? (int)$game->$key->tstsg->oreb : 0;
                            $teams_pivot_data[$this_game->$scope->id]['dreb'] = property_exists($game->$key->tstsg,'dreb') ? (int)$game->$key->tstsg->dreb : 0;
                            $teams_pivot_data[$this_game->$scope->id]['reb'] = property_exists($game->$key->tstsg,'reb') ? (int)$game->$key->tstsg->reb : 0;
                            $teams_pivot_data[$this_game->$scope->id]['ast'] = property_exists($game->$key->tstsg,'ast') ? (int)$game->$key->tstsg->ast : 0;
                            $teams_pivot_data[$this_game->$scope->id]['stl'] = property_exists($game->$key->tstsg,'stl') ? (int)$game->$key->tstsg->stl : 0;
                            $teams_pivot_data[$this_game->$scope->id]['blk'] = property_exists($game->$key->tstsg,'blk') ? (int)$game->$key->tstsg->blk : 0;
                            $teams_pivot_data[$this_game->$scope->id]['pf'] = property_exists($game->$key->tstsg,'pf') ? (int)$game->$key->tstsg->pf : 0;
                            $teams_pivot_data[$this_game->$scope->id]['tov'] = property_exists($game->$key->tstsg,'tov') ? (int)$game->$key->tstsg->tov : 0;
                            $teams_pivot_data[$this_game->$scope->id]['fbpts'] = property_exists($game->$key->tstsg,'fbpts') ? (int)$game->$key->tstsg->fbpts : 0;
                            $teams_pivot_data[$this_game->$scope->id]['fbptsa'] = property_exists($game->$key->tstsg,'fbptsa') ? (int)$game->$key->tstsg->fbptsa : 0;
                            $teams_pivot_data[$this_game->$scope->id]['fbptsm'] = property_exists($game->$key->tstsg,'fbptsm') ? (int)$game->$key->tstsg->fbptsm : 0;
                            $teams_pivot_data[$this_game->$scope->id]['pip'] = property_exists($game->$key->tstsg,'pip') ? (int)$game->$key->tstsg->pip : 0;
                            $teams_pivot_data[$this_game->$scope->id]['pipa'] = property_exists($game->$key->tstsg,'pipa') ? (int)$game->$key->tstsg->pipa : 0;
                            $teams_pivot_data[$this_game->$scope->id]['pipm'] = property_exists($game->$key->tstsg,'pipm') ? (int)$game->$key->tstsg->pipm : 0;
                            $teams_pivot_data[$this_game->$scope->id]['ble'] = property_exists($game->$key->tstsg,'ble') ? (int)$game->$key->tstsg->ble : 0;
                            $teams_pivot_data[$this_game->$scope->id]['bpts'] = property_exists($game->$key->tstsg,'bpts') ? (int)$game->$key->tstsg->bpts : 0;
                            $teams_pivot_data[$this_game->$scope->id]['tf'] = property_exists($game->$key->tstsg,'tf') ? (int)$game->$key->tstsg->tf : 0;
                            $teams_pivot_data[$this_game->$scope->id]['scp'] = property_exists($game->$key->tstsg,'scp') ? (int)$game->$key->tstsg->scp : 0;
                            $teams_pivot_data[$this_game->$scope->id]['tmreb'] = property_exists($game->$key->tstsg,'tmreb') ? (int)$game->$key->tstsg->tmreb : 0;
                            $teams_pivot_data[$this_game->$scope->id]['tmtov'] = property_exists($game->$key->tstsg,'tmtov') ? (int)$game->$key->tstsg->tmtov : 0;
                            $teams_pivot_data[$this_game->$scope->id]['potov'] = property_exists($game->$key->tstsg,'potov') ? (int)$game->$key->tstsg->potov : 0;
                        }
                        if(property_exists($game->$key,'pstsg')){
                            foreach($game->$key->pstsg as $player){
                                $this_player = Player::updateOrCreate(
                                    [
                                        'pid' => $player->pid
                                    ],
                                    [
                                        'first_name' => $player->fn,
                                        'last_name' =>$player->ln
                                    ]
                                );
                                $this_box_score = BoxScore::firstOrNew(
                                    [
                                        'game_id' => $this_game->id,
                                        'team_id' => $this_game->$scope->id,
                                        'player_id' => $this_player->id
                                    ]
                                );
                                $this_box_score->jersey = (int)$player->num;
                                $this_box_score->position = $player->pos;
                                $this_box_score->total_seconds = (int)$player->totsec;
                                $this_box_score->fga = (int)$player->fga;
                                $this_box_score->fgm = (int)$player->fgm;
                                $this_box_score->tpa = (int)$player->tpa;
                                $this_box_score->tpm = (int)$player->tpm;
                                $this_box_score->fta = (int)$player->fta;
                                $this_box_score->ftm = (int)$player->ftm;
                                $this_box_score->oreb = (int)$player->oreb;
                                $this_box_score->dreb = (int)$player->dreb;
                                $this_box_score->reb = (int)$player->reb;
                                $this_box_score->ast = (int)$player->ast;
                                $this_box_score->stl = (int)$player->stl;
                                $this_box_score->blk = (int)$player->blk;
                                $this_box_score->pf = (int)$player->pf;
                                $this_box_score->pts = (int)$player->pts;
                                $this_box_score->tov = (int)$player->tov;
                                $this_box_score->fbpts = (int)$player->fbpts;
                                $this_box_score->fbptsa = (int)$player->fbptsa;
                                $this_box_score->fbptsm = (int)$player->fbptsm;
                                $this_box_score->pip = (int)$player->pip;
                                $this_box_score->pipa = (int)$player->pipa;
                                $this_box_score->pipm = (int)$player->pipm;
                                $this_box_score->is_on_court = (bool)$player->court;
                                $this_box_score->pm = (int)$player->pm;
                                $this_box_score->blka = (int)$player->blka;
                                $this_box_score->tf = (int)$player->tf;
                                $this_box_score->status = $player->status;
                                $this_box_score->memo = !empty($player->status) ? $player->status : null;
                                $this_box_score->save();
                            }
                        }
                    }
                    // SAVE TEAM RELATIONS
                    $this_game->teams()->sync($teams_pivot_data);

                    $this->command->info('Imported box score data for gid '.$this_game->gid.' (took '.number_format((microtime(true) - $game_start),3).' seconds).');
                    $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
                }
                else{
                    $this->command->error('Game detail feed for gid '.$this_game->gid.' returned empty.');
                }
            }
            else{
                $this->command->error('Error retrieving game detail feed for gid '.$this_game->gid.'.');
            }
        }
        $this->command->info('Imported box score data for '.count($games).' games (took '.number_format((microtime(true) - $seeder_start),3).' seconds).');
        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
    }
}
