<?php

namespace Modules\Stats\Database\Seeders;

use Illuminate\Database\Seeder;

use GuzzleHttp\Client as GuzzleClient;

use Modules\Stats\Entities\League;
use Modules\Stats\Entities\Team;

class TeamsSeeder extends Seeder
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
        League::unguard();
        Team::unguard();
        */

        $seeder_start = microtime(true);
        $this->command->info('Getting leagues to seed Team models...');
        $leagues = League::all();
        $start_year = (int)config('nba.season_year');
        $client = new GuzzleClient();
        $this->command->info('Found '.count($leagues).' leagues.');
        foreach($leagues as $league){
            $league_start = microtime(true);
            $this->command->info('Getting team information for '.$league->name.'...');
            $url = 'https://data.nba.com/data/v2015/json/mobile_teams/'.$league->code.'/'.$start_year.'/teams/'.$league->lid.'_team_info.json';
            $result = $client->get($url,['http_errors' => false]);
            if($result->getStatusCode() === 200){
                $teams_data = @json_decode($result->getBody()->getContents());
                if(!empty($teams_data) && property_exists($teams_data,'tms') && property_exists($teams_data->tms,'t')){
                    $this->command->info('Found '.count($teams_data->tms->t).' teams in the '.$league->name.' feed. Importing...');
                    foreach($teams_data->tms->t as $team){
                        $team_start = microtime(true);
                        $this_team = Team::updateOrCreate(
                            [
                                'tid' => $team->tid,
                                'league_id' => $league->id
                            ],
                            [
                                'name' => $team->tn,
                                'location' => $team->tc,
                                'abbreviation' => $team->ta,
                                'division' => $team->di,
                                'conference' => $team->co,
                            ]
                        );
                        $this->command->info('Imported '.$this_team->location.' '.$this_team->name.' into the database (took '.number_format((microtime(true) - $team_start),3).' seconds).');
                        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
                    }
                    $this->command->info('Imported '.count($teams_data->tms->t).' teams from '.$league->name.' feed (took '.number_format((microtime(true) - $league_start),3).' seconds)');
                    $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
                }
                else{
                    $this->command->error('Team information for '.$league->name.' returned empty.');
                }
            }
            else{
                $this->command->error('Error retrieving team information for '.$league->name.'.');
            }
        }
        $this->command->info('Seeded teams (took '.number_format((microtime(true) - $seeder_start),3).' seconds).');
        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
    }
}
