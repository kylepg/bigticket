<?php

namespace Modules\Stats\Database\Seeders;

use Illuminate\Database\Seeder;

class StatsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit','2048MB');
        $this->call([
            LeaguesSeeder::class,
            TeamsSeeder::class,
            PlayersSeeder::class,
            GamesSeeder::class,
            BoxScoresSeeder::class,
            PlayByPlaySeeder::class
        ]);
    }
}
