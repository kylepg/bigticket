<?php

namespace Modules\Stats\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Stats\Entities\League;

class LeaguesSeeder extends Seeder
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
        */

        //!! HIDING LEAGUES WE WON'T NEED PLAYERS FOR !!//
        $leagues = [
            (object)[
                'lid' => '00',
                'code' => 'nba',
                'name' => 'NBA'
            ],
            /*(object)[
                'lid' => '10',
                'code' => 'wnba',
                'name' => 'WNBA'
            ],
            (object)[
                'lid' => '14',
                'code' => 'orlando',
                'name' => 'NBA Orlando Summer League'
            ],
            (object)[
                'lid' => '15',
                'code' => 'vegas',
                'name' => 'NBA Las Vegas Summer League'
            ],
            (object)[
                'lid' => '00',
                'code' => 'utah',
                'name' => 'NBA Utah Summer League (Rocky Mountain Revue)'
            ],*/
            (object)[
                'lid' => '20',
                'code' => 'dleague',
                'name' => 'NBA G-League'
            ],
        ];

        $this->command->info('Seeding leagues ('.count($leagues).' leagues).');
        $seeder_start = microtime(true);
        foreach($leagues as $league){
            $league_start = microtime(true);
            $this_league = League::firstOrCreate(
                [
                    'lid' => $league->lid,
                    'code' => $league->code
                ],
                [
                    'name' => $league->name
                ]
            );

            $this->command->info('Created '.$this_league->name.' league (took '.number_format((microtime(true) - $league_start),3).' seconds).');
            $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
        }
        $this->command->info('Seeded leagues (took '.number_format((microtime(true) - $seeder_start),3).' seconds).');
        $this->command->line('MEMORY USAGE: '.memory_get_usage(false));
    }
}
