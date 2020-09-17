<?php

namespace Modules\Stats\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;

use Modules\Stats\Entities\League;

class CheckTodaysScoresFeed extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stats:check_todays_scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the today\'s scores feed from the NBA\'s mobile stat feeds.';

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
        // Check if Tags module is enabled
        $tags_enabled = array_key_exists('Tags',\Module::allEnabled());

        //!! MANUALLY DEFINE LEAGUE !!//
        $league = League::where('name','=','NBA')->first();
        $season_year = (int)config('nba.season_year');
        $now = Carbon::now();
        // $month_code = $now->format('m');

        if(!empty($league)){
            $this->info('Getting today\'s games feed ...');
            $client = new GuzzleClient();

            //!! THIS IS FOR MONTH BY MONTH SCHEDULE !!//
            // $url = 'https://data.nba.com/data/v2015/json/mobile_teams/'.$league->code.'/'.$season_year.'/league/'.$league->lid.'_league_schedule_'.$month_code.'.json';

            $url = 'https://data.nba.com/data/v2015//json/mobile_teams/'.$league->code.'/'.$season_year.'/scores/'.$league->lid.'_todays_scores.json';
            $result = $client->get($url, [
                'http_errors' => false
            ]);
            if($result->getStatusCode() === 200){
                $scores_data = @json_decode($result->getBody()->getContents());
                if(!empty($scores_data) && property_exists($scores_data,'gs') && property_exists($scores_data->gs,'g')){

                }
            }
        }
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
