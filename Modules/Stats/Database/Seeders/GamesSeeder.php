<?php

namespace Modules\Stats\Database\Seeders;

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleClient;
use Carbon\Carbon;

use Modules\Stats\Entities\Arena;
use Modules\Stats\Entities\Broadcaster;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\League;
use Modules\Stats\Entities\Season;
use Modules\Stats\Entities\Team;

class GamesSeeder extends Seeder
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
        Arena::unguard();
        Broadcaster::unguard();
        Game::unguard();
        League::unguard();
        Season::unguard();
        Team::unguard();
        */

        \DB::disableQueryLog();

        $seeder_start = microtime(true);

        $this->command->info('Checking for NBA league model...');
        $league = League::where('lid','=','00')->where('code','=','nba')->first();
        if(!empty($league)){
            $season_types = [
                'pre' => (object)[
                    'id' => '01',
                    'is_nba_arena' => false
                ],
                'regular' => (object)[
                    'id' => '02',
                    'is_nba_arena' => true
                ],
                'post' => (object)[
                    'id' => '04',
                    'is_nba_arena' => false
                ]
            ];

            $start_year = (int)config('nba.season_year');
            $end_year = $start_year + 1;
            $season_name = $start_year.'-'.substr($end_year,-2);
            $this_season = Season::firstOrCreate(
                [
                    'name' => $season_name,
                    'league_id' => $league->id
                ],
                [
                    'start_year' => $start_year,
                    'end_year' => $end_year
                ]
            );
            $this->command->info('League found. Getting games starting at the '.$season_name.' season.');
            $client = new GuzzleClient();
            foreach($season_types as $subseason_type => $subseason){
                $season_start = microtime(true);
                $this->command->info('Getting games for the '.$season_name.' '.$subseason_type.' season.');
                $url = 'https://data.nba.com/data/v2015/json/mobile_teams/'.$league->code.'/'.$start_year.'/teams/celtics_schedule_'.$subseason->id.'.json';
                $result = $client->get($url,['http_errors' => false]);
                if($result->getStatusCode() === 200){
                    $season_data = @json_decode($result->getBody()->getContents());
                    if(!empty($season_data) && property_exists($season_data,'gscd') && property_exists($season_data->gscd,'g')){
                        $this->command->info('Found '.count($season_data->gscd->g).' games in the '.$season_name.' '.$subseason_type.' season feed. Importing...');
                        foreach($season_data->gscd->g as $game){
                            $game_start = microtime(true);
                            // FIND GAME
                            $this_game = Game::firstOrNew([
                                'gid' => $game->gid
                            ]);

                            // FIND ARENA
                            $this_arena = Arena::firstOrNew(
                                [
                                    'name' => $game->an,
                                    'city' => $game->ac,
                                    'state' => $game->as
                                ]
                            );
                            $this_arena->is_nba_arena = $subseason->is_nba_arena;
                            $this_arena->save();

                            $this_game->arena_id = $this_arena->id;
                            $this_game->season_id = $this_season->id;
                            $this_game->gcode = $game->gcode;
                            $this_game->season_type = $subseason_type;

                            // Try to parse game string to determine if it's legit
                            $date_time_string = str_replace('T',' ',$game->etm);
                            try {
                                $date_time = Carbon::parse($date_time_string);
                                $this_game->date_time = $date_time;
                            } catch (\Exception $e) {
                                // Do nothing, date_time will be null and assumed TBD
                            }

                            if($subseason_type === 'post'){
                                $this_game->round = (int)substr($game->gid,-3,1);
                            }
                            $this_game->status = (int)$game->st;
                            // SAVE GAME BEFORE MOVING ON TO RELATIONS
                            $this_game->save();

                            // DEFINE TEAMS PIVOT TABLE ARRAY
                            $teams_pivot_data = [];

                            // FIND VISITING TEAM
                            $visitor_team = Team::updateOrCreate(
                                [
                                    'tid' => $game->v->tid
                                ],
                                [
                                    'name' => $game->v->tn,
                                    'location' => $game->v->tc,
                                    'abbreviation' => $game->v->ta,
                                ]
                            );
                            if($subseason_type === 'regular' || $subseason_type === 'post'){
                                $visitor_team->league_id = $league->id;
                                $visitor_team->save();
                            }
                            $teams_pivot_data[$visitor_team->id] = [
                                's' => (int)$game->v->s,
                                'role' => 'visitor'
                            ];

                            // FIND HOME TEAM
                            $home_team = Team::updateOrCreate(
                                [
                                    'tid' => $game->h->tid
                                ],
                                [
                                    'name' => $game->h->tn,
                                    'location' => $game->h->tc,
                                    'abbreviation' => $game->h->ta,
                                ]
                            );
                            if($subseason->is_nba_arena){
                                $home_team->arena_id = $this_arena->id;
                            }
                            if($subseason_type === 'regular' || $subseason_type === 'post'){
                                $home_team->league_id = $league->id;
                            }
                            $home_team->save();
                            $teams_pivot_data[$home_team->id] = [
                                's' => (int)$game->h->s,
                                'role' => 'home'
                            ];

                            // SAVE TEAM RELATIONS
                            $this_game->teams()->sync($teams_pivot_data);

                            // DEFINE BROADCASTERS PIVOT TABLE ARRAY
                            $broadcasters_pivot_data = [];

                            // LOOP THROUGH BROADCASTERS

                            foreach($game->bd->b as $broadcaster){
                                // FIND BROADCASTER
                                $this_broadcaster = Broadcaster::updateOrCreate(
                                    [
                                        'name' => $broadcaster->disp,
                                        'type' => $broadcaster->type
                                    ],
                                    [
                                        'language' => $broadcaster->lan
                                    ]
                                );
                                $broadcasters_pivot_data[$this_broadcaster->id] = [
                                    'scope' => $broadcaster->scope
                                ];
                            }
                            // SAVE BROADCASTER RELATIONS
                            $this_game->broadcasters()->sync($broadcasters_pivot_data);

                            $this->command->info('Imported '.$this_game->gid.' into the database (took '.number_format((microtime(true) - $game_start),3).' seconds).');
                            $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
                        }
                        $this->command->info('Imported '.count($season_data->gscd->g).' games into the database for the '.$season_name.' '.$subseason_type.' season (took '.number_format((microtime(true) - $season_start),3).' seconds).');
                        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
                    }
                    else{
                        $this->command->error($season_name.' '.$subseason_type.' season feed returned empty.');
                    }
                }
                else{
                    $this->command->error('Error retrieving schedule feed for the '.$season_name.' '.$subseason_type.' season.');
                }
            }
            $this->command->info('Imported '.count($season_types).' seasons into the database (took '.number_format((microtime(true) - $seeder_start),3).' seconds).');
            $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
        }
        else{
            $this->command->error('Couldn\'t find NBA league model in database.');
        }
    }
}
