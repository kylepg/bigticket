<?php

namespace Modules\Stats\Database\Seeders;

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleClient;

use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\Play;
use Modules\Stats\Entities\Player;

class PlayByPlaySeeder extends Seeder
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
        Game::unguard();
        Play::unguard();
        Player::unguard();
        */

        \DB::disableQueryLog();

        $seeder_start = microtime(true);
        $client = new GuzzleClient();
        $games = Game::all();
        $this->command->info('Getting play-by-play data for all games in the database ('.count($games).' games)...');

        foreach($games as $this_game){
            $game_start = microtime(true);
            $periods = $this_game->period;
            $this->command->info('Getting play-by-play data for gid '.$this_game->gid.' ('.$periods.' periods)...');
            if($periods > 0){
                for($i = 1; $i <= $periods; $i++){
                    $period_start = microtime(true);
                    $this->command->info('Getting play-by-play data for period '.$i.' of gid '.$this_game->gid.'...');
                    $url = 'https://data.nba.com/data/v2015/json/mobile_teams/nba/'.$this_game->season_year.'/scores/pbp/'.$this_game->gid.'_'.$i.'_pbp.json';
                    $result = $client->get($url);
                    if($result->getStatusCode() === 200){
                        $period_data = @json_decode($result->getBody()->getContents());
                        if(!empty($period_data) && property_exists($period_data,'g')){
                            $period = $period_data->g;
                            $this->command->info('Found '.count($period->pla).' plays in period '.$i.'. Importing...');
                            foreach($period->pla as $play){
                                $this_play = Play::firstOrNew(
                                    [
                                        'event_id' => (int)$play->evt,
                                        'game_id' => $this_game->id
                                    ]
                                );
                                $this_team = $this_game->teams()->where('tid','=',$play->tid)->first();
                                if(!empty($this_team)){
                                    $this_play->team_id = $this_team->id;
                                }
                                $this_play->period = (int)$period->p;
                                $this_play->clock = $play->cl;
                                if(gettype($this_play->clock) === 'string' && preg_match('/\d?\d\:\d\d(\.\d\d)?/',$this_play->clock)){
                                    $seconds_array = explode(':',$this_play->clock);
                                    $period_seconds = (12 * 60);
                                    $seconds = (($this_play->period - 1) * $period_seconds) + ($period_seconds - ((int)$seconds_array[0] * 60) - (float)$seconds_array[1]);
                                    $this_play->seconds = $seconds;
                                }
                                $this_play->description = $play->de;
                                $this_play->x_coordinate = (int)$play->locX;
                                $this_play->y_coordinate = (int)$play->locY;
                                $this_play->home_score = (int)$play->hs;
                                $this_play->visitor_score = (int)$play->vs;
                                $this_play->event_type_id = (int)$play->etype;
                                $this_play->action_type_id = (int)$play->mtype;
                                $this_play->option_1 = (int)$play->opt1;
                                $this_play->option_2 = (int)$play->opt2;
                                $this_play->order = (int)$play->ord;
                                $this_play->save();

                                // DEFINE PLAYERS PIVOT TABLE ARRAY
                                $players_pivot_data = [];
                                if(!empty($play->pid)){
                                    $player = Player::where('pid','=',(int)$play->pid)->first();
                                    if(!empty($player)){
                                        $players_pivot_data[$player->id] = [
                                            'role' => 'primary'
                                        ];
                                    }
                                }
                                if(!empty($play->opid)){
                                    $opposing_player = Player::where('pid','=',(int)$play->opid)->first();
                                    if(!empty($opposing_player)){
                                        $players_pivot_data[$opposing_player->id] = [
                                            'role' => 'opponent'
                                        ];
                                    }
                                }
                                if(!empty($play->epid)){
                                    $teammate_player = Player::where('pid','=',(int)$play->epid)->first();
                                    if(!empty($teammate_player)){
                                        $players_pivot_data[$teammate_player->id] = [
                                            'role' => 'teammate'
                                        ];
                                    }
                                }
                                if(!empty($players_pivot_data)){
                                    // SAVE PLAYER RELATIONS
                                    $this_play->players()->sync($players_pivot_data);
                                }
                            }
                            $this->command->info('Imported '.count($period->pla).' plays from period '.$i.' (took '.number_format((microtime(true) - $period_start),3).' seconds)');
                            $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
                        }
                        else{
                            $this->command->error('Play-by-play feed for gid '.$this_game->gid.' (period '.$i.') returned empty.');
                        }
                    }
                    else{
                        $this->command->error('Error retrieving play-by-play feed for gid '.$this_game->gid.' (period '.$i.').');
                    }
                }
            }
            $this->command->info('Imported all plays from gid '.$this_game->gid.' - '.$periods.' periods (took '.number_format((microtime(true) - $game_start),3).' seconds).');
            $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
        }
        $this->command->info('Seeded plays (took '.number_format((microtime(true) - $seeder_start),3).' seconds).');
        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
    }
}
