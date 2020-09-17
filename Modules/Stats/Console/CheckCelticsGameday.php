<?php

namespace Modules\Stats\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use GuzzleHttp\Client as GuzzleClient;

class CheckCelticsGameday extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stats:check_celtics_gameday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks to see if the Celtics play today.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $is_gameday = false;
        $season_year = (int)config('nba.season_year');
        $this->info('Getting today\'s games feed ...');
        $client = new GuzzleClient();
        $url = 'https://data.nba.com/data/v2015//json/mobile_teams/nba/'.$season_year.'/scores/00_todays_scores.json';
        $result = $client->get($url, [
            'http_errors' => false
        ]);
        if($result->getStatusCode() === 200){
            $scores_data = @json_decode($result->getBody()->getContents());
            if(!empty($scores_data) && property_exists($scores_data,'gs') && property_exists($scores_data->gs,'g')){
                foreach($scores_data->gs->g as $game){
                    if($game->v->ta === 'BOS' || $game->h->ta === 'BOS'){
                        $is_gameday = true;
                    }
                }
            }
        }
        simpleSetting('is_celtics_gameday',$is_gameday);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
