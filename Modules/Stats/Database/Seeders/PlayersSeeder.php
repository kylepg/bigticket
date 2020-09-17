<?php

namespace Modules\Stats\Database\Seeders;

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleClient;
use Carbon\Carbon;

use Modules\Stats\Entities\Player;
use Modules\Stats\Entities\Team;

class PlayersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function importPlayer($player,$team){
        $player_start = microtime(true);
            $this_player = Player::firstOrNew(
                [
                    'pid' => $player->pid
                ]
            );
            $this_player->first_name = property_exists($player,'fn') ? $player->fn : null;
            $this_player->last_name = property_exists($player,'fn') ? $player->ln : null;
            $this_player->jersey = property_exists($player,'fn') ? $player->num : null;
            $this_player->position = property_exists($player,'fn') ? $player->pos : null;
            $this_player->dob = (property_exists($player,'dob') && Carbon::createFromFormat('Y-m-d',$player->dob)->format('Y-m-d') === $player->dob) ? Carbon::parse($player->dob) : null;
            if(property_exists($player,'hcc') && !empty($player->hcc)){
                if(strpos($player->hcc,'/') !== false){
                    $this_player->prior = explode('/',$player->hcc)[0];
                    $this_player->country = explode('/',$player->hcc)[1];
                }
                else{
                    $this_player->country = $player->hcc;
                }
            }
            if(property_exists($player,'ht') && !empty($player->ht)){
                if(strpos($player->hcc,'-') !== false){
                    $this_player->height = ((int)explode('-',$player->ht)[0] * 12) + (int)explode('-',$player->ht)[1];
                }
                else{
                    $this_player->height = (int)$player->ht * 12;
                }
            }
            $this_player->weight = property_exists($player,'wt') && !empty($player->wt) ? (int)$player->wt : null;
            $this_player->is_active = true;
            $this_player->save();

            //!! MAY NEED TO ADJUST RELATIONSHIP TO ALLOW ROSTER SHARING FOR G-LEAGUE AND NBA ACTIVE ROSTERS !!//

            $this_player->teams()->detach();
            $this_player->teams()->save($team);

            $this->command->info('Imported '.$this_player->first_name.' '.$this_player->last_name.' into the database (took '.number_format((microtime(true) - $player_start),3).' seconds).');
            $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //!! KEEPING MODEL GUARDS ON UNLESS WE RUN INTO ISSUES !!//
        /*
        Player::unguard();
        Team::unguard();
        */

        \DB::disableQueryLog();

        $seeder_start = microtime(true);
        $this->command->info('Getting teams to seed Player models...');
        $teams = Team::with('league')->get();
        $start_year = (int)config('nba.season_year');
        $client = new GuzzleClient();
        $this->command->info('Getting roster information for '.count($teams).' teams...');
        foreach($teams as $team){
            $team_start = microtime(true);
            $this->command->info('Getting roster information for '.$team->location.' '.$team->name.'...');
            if(!empty($team->league)){
                $team_code = strtolower($team->name);
                if($team_code === 'trail blazers'){
                    $team_code = 'trail_blazers';
                }
                $url = 'https://data.nba.com/data/v2015/json/mobile_teams/'.$team->league->code.'/'.$start_year.'/teams/'.$team_code.'_roster.json';
                $result = $client->get($url,['http_errors' => false]);
                if($result->getStatusCode() === 200){
                    $roster_data = @json_decode($result->getBody()->getContents());
                    if(!empty($roster_data) && property_exists($roster_data,'t') && property_exists($roster_data->t,'pl')){
                        $this->command->info('Found '.count($roster_data->t->pl).' players on the '.$team->location.' '.$team->name.' roster. Importing...');
                        foreach($roster_data->t->pl as $player){
                            $this->importPlayer($player,$team);
                            /*
                            $player_start = microtime(true);
                            $this->command->line('MEMORY USAGE BEFORE $THIS_PLAYER FIRST OR NEW: '.memory_get_usage(false));
                            $this_player = Player::firstOrNew(
                                [
                                    'pid' => $player->pid
                                ]
                            );
                            $this->command->line('MEMORY USAGE AFTER $THIS_PLAYER FIRST OR NEW: '.memory_get_usage(false));
                            $this_player->first_name = property_exists($player,'fn') ? $player->fn : null;
                            $this_player->last_name = property_exists($player,'fn') ? $player->ln : null;
                            $this_player->jersey = property_exists($player,'fn') ? $player->num : null;
                            $this_player->position = property_exists($player,'fn') ? $player->pos : null;
                            $this_player->dob = (property_exists($player,'dob') && Carbon::createFromFormat('Y-m-d',$player->dob)->format('Y-m-d') === $player->dob) ? Carbon::parse($player->dob) : null;
                            if(property_exists($player,'hcc') && !empty($player->hcc)){
                                if(strpos($player->hcc,'/') !== false){
                                    $this_player->prior = explode('/',$player->hcc)[0];
                                    $this_player->country = explode('/',$player->hcc)[1];
                                }
                                else{
                                    $this_player->country = $player->hcc;
                                }
                            }
                            if(property_exists($player,'ht') && !empty($player->ht)){
                                if(strpos($player->hcc,'-') !== false){
                                    $this_player->height = ((int)explode('-',$player->ht)[0] * 12) + (int)explode('-',$player->ht)[1];
                                }
                                else{
                                    $this_player->height = (int)$player->ht * 12;
                                }
                            }
                            $this_player->weight = property_exists($player,'wt') && !empty($player->wt) ? (int)$player->wt : null;
                            $this_player->is_active = true;
                            $this->command->line('MEMORY USAGE BEFORE $THIS_PLAYER SAVE: '.memory_get_usage(false));
                            $this_player->save();
                            $this->command->line('MEMORY USAGE AFTER $THIS_PLAYER SAVE: '.memory_get_usage(false));

                            //!! MAY NEED TO ADJUST RELATIONSHIP TO ALLOW ROSTER SHARING FOR G-LEAGUE AND NBA ACTIVE ROSTERS !!//

                            $this->command->line('MEMORY USAGE BEFORE $THIS_PLAYER DETACH AND SAVE TEAM: '.memory_get_usage(false));
                            $this_player->teams()->detach();
                            $this_player->teams()->save($team);
                            $this->command->line('MEMORY USAGE AFTER $THIS_PLAYER DETACH AND SAVE TEAM: '.memory_get_usage(false));

                            $this->command->info('Imported '.$this_player->first_name.' '.$this_player->last_name.' into the database (took '.number_format((microtime(true) - $player_start),3).' seconds).');

                            $this->command->line('MEMORY USAGE BEFORE UNSET: '.memory_get_usage(false));
                            //!! START UNSET CODE FOR CURRENT SCOPE !!//
                            // unset($player,$player_start,$this_player);
                            $player = null;
                            $player_start = null;
                            $this_player = null;
                            //!! END UNSET CODE FOR CURRENT SCOPE !!//

                            $this->command->line('MEMORY USAGE AFTER UNSET: '.memory_get_usage(false));
                            */
                        }

                        $this->command->info('Imported '.count($roster_data->t->pl).' players from the the '.$team->location.' '.$team->name.' roster (took '.number_format((microtime(true) - $team_start),3).' seconds)');
                        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
                    }
                    else{
                        $this->command->error('Roster information for '.$team->location.' '.$team->name.' returned empty.');
                    }
                }
                else{
                    $this->command->error('Error retrieving roster information for '.$team->location.' '.$team->name.'.');
                }
            }
            else{
                $this->command->error('Error determining league status for '.$team->location.' '.$team->name.'.');
            }
        }

        $this->command->info('Seeded players (took '.number_format((microtime(true) - $seeder_start),3).' seconds).');
        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
    }
}
